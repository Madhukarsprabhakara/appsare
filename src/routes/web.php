<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Team;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/phpinfo', function() {
    // dd(extension_loaded('soap'));
    return phpinfo();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    // Route::get('/dashboard', [App\Http\Controllers\TrackerController::class, 'index'])->name('dashboard');
    #Trackers route
    Route::get('/trackers', [App\Http\Controllers\TrackerController::class, 'index'])->name('trackers.index');
    Route::get('/trackers/create', [App\Http\Controllers\TrackerController::class, 'create'])->name('trackers.create');
    Route::post('/trackers', [App\Http\Controllers\TrackerController::class, 'store'])->name('trackers.store');
    Route::get('/trackers/{tracker}', [App\Http\Controllers\TrackerController::class, 'show'])->name('trackers.show');
    Route::get('/trackers/{tracker}/edit', [App\Http\Controllers\TrackerController::class, 'edit'])->name('trackers.edit');
    Route::put('/trackers/{tracker}', [App\Http\Controllers\TrackerController::class, 'update'])->name('trackers.update');
    Route::delete('/trackers/{tracker}', [App\Http\Controllers\TrackerController::class, 'destroy'])->name('trackers.destroy');

    # Slack redirect routes
    Route::get('/auth/slack/redirect', [App\Http\Controllers\SlackConnectController::class, 'redirect'])->name('slack.redirect');
    Route::get('/auth/slack/callback', [App\Http\Controllers\SlackConnectController::class, 'saveSlackToken'])->name('slack.save');
    Route::get('/statuscheck', function(){

        $team=Team::find(1);
        $all_users=$team->allUsers();
        foreach ($all_users as $user)
        {
            return $user->id;   
        }
        $start_time = microtime(true);
        $response = Http::head('https://seasonsurvey.com');
        $end_time = microtime(true);
        $response_time = $end_time - $start_time;
        return  $response_time*1000;

        $host = 'demo-test.sopact.com';
$port = 443;

$context = stream_context_create([
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
        'capture_peer_cert' => true,
    ],
]);

$stream = stream_socket_client("ssl://$host:$port", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);

if (!$stream) {
    echo "Failed to connect to $host:$port - $errstr ($errno)";
    exit;
}

$cont = stream_context_get_options($stream);
$cert = $cont['ssl']['peer_certificate'];

$parsedCertificate = openssl_x509_parse($cert);

return [
    'subject' => $parsedCertificate['subject'],
    'issuer' => $parsedCertificate['issuer'],
    'validFrom' => $parsedCertificate['validFrom_time_t'],
    'validTo' => $parsedCertificate['validTo_time_t'],
];
    });
});
