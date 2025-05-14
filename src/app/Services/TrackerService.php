<?php

namespace App\Services;

use App\Models\Tracker;
use App\Models\Team;
use Pdp\Rules;
use Pdp\Domain;
use App\Events\TrackerCreated;
use App\Models\TrackerDomainCert;

class TrackerService
{
    public function getTrackersOnTeamId(Team $team)
    {

        return $team->trackers;
    }
    public function getTrackersOnly(Team $team)
    {
        return $team->trackersOnly;
    }
    public function storeTracker(array $tracker_to_save, $domain_expiry, $ssl_cert_expiry)
    {
        $tracker = Tracker::create($tracker_to_save);
        if ($tracker) {
            //Dispatch a background job to get ssl and domain expiry
            event(new TrackerCreated($tracker, $domain_expiry, $ssl_cert_expiry));

            return true;
        }
        throw new \Exception('Something went wrong, could not save your tracker. Please try again.');
    }
    public function updateTracker($data, Tracker $tracker, $domain_expiry, $ssl_cert_expiry)
    {
        $tracker_domain_cert = TrackerDomainCert::updateOrCreate(
            ['tracker_id' => $tracker->id],
            ['domain_expires_at' => $domain_expiry, 'cert_expires_at' => $ssl_cert_expiry]
        );
        $tracker->update([
            'url' => $data['url'],
        ]);
        
    }
    public function checkDNS($url)
    {
        $url = parse_url($url, PHP_URL_HOST);
        $dns = dns_get_record($url, DNS_A);
        if ($dns) {
            if ($dns[0]['ip']) {
                return true;
            }
        }
        return false;
    }
    public function checkDomainNameExpiry($url)
    {
        // Extract the host from the URL
        $url = parse_url($url, PHP_URL_HOST);

        $publicSuffixList = Rules::fromPath('https://data.iana.org/TLD/tlds-alpha-by-domain.txt');
        $domain = Domain::fromIDNA2008($url);
        // Validate the URL
        $result = $publicSuffixList->resolve($domain);
        $root_domain = $result->registrableDomain()->toString();
        if (!$url) {
            throw new \Exception("Invalid URL provided.");
        }

        // Get the domain name expiry date using whois command
        $output = shell_exec("whois {$root_domain}");

        // Check if the output is empty
        if (empty($output)) {
            abort(403, "Failed to retrieve domain information for {$url}.");
            //throw new \Exception("Failed to retrieve domain information for {$url}.");
        }

        // Parse the output to find the expiry date
        preg_match('/Expiry Date:\s*(\d{4}-\d{2}-\d{2})/', $output, $matches);

        // Check if the expiry date was found
        if (isset($matches[1])) {
            return $matches[1];
        }
        return false;
    }
    public function checkSSLCertExpiry($url)
    {
        // Extract the host from the URL
        $url = parse_url($url, PHP_URL_HOST);
        $port = 443;
        // Validate the URL
        if (!$url) {
            throw new \Exception("Invalid URL provided.");
        }

        // Create an SSL stream context to capture the peer certificate
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'capture_peer_cert' => true,
            ],
        ]);

        // Attempt to connect to the server on port 443
        $stream = stream_socket_client("ssl://$url:$port", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);

        // Check if the connection was successful
        if (!$stream) {
            abort(403, "Failed to connect to {$url} on port 443: {$errstr} ({$errno})");
            //throw new \Exception("Failed to connect to {$url} on port 443: {$errstr} ({$errno})");
        }

        // Retrieve the SSL certificate parameters
        $cont = stream_context_get_options($stream);
        $cert = $cont['ssl']['peer_certificate'];

        // Check if the peer certificate is available
        if (empty($cont['ssl']['peer_certificate'])) {
            abort(403, "No SSL certificate found for {$url}.");
            //throw new \Exception("No SSL certificate found for {$url}.");
        }

        // Parse the certificate
        $cert = openssl_x509_parse($cert);

        // Check if the certificate parsing was successful
        if (!$cert || !isset($cert['validTo_time_t'])) {
            abort(403, "Failed to parse SSL certificate for {$url}.");
            //throw new \Exception("Failed to parse SSL certificate for {$url}.");
        }

        // Return the expiry date of the certificate
        if (isset($cert['validTo_time_t'])) {
            // Convert the expiry date to a human-readable format
            return date('Y-m-d H:i:s', $cert['validTo_time_t']);
        }
        return false;
    }
}
