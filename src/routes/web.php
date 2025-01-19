<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Team;
Route::get('/', function () {
    if (\Auth::check())
    {
        return to_route('trackers.index');
    }
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
Route::get('/layout', function() {
    return Inertia::render('Landingv2');
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

    #Notifications route
    Route::get('/notifications',function() {
        return Inertia::render('Notifications/Show');
    })->name('notifications.index');

    # Integrations routes
    Route::get('/integrations', [App\Http\Controllers\IntegrationController::class, 'index'])->name('integrations.index');

    # Slack redirect routes
    Route::get('/auth/slack/redirect', [App\Http\Controllers\SlackConnectController::class, 'redirect'])->name('slack.redirect');
    Route::get('/auth/slack/callback', [App\Http\Controllers\SlackConnectController::class, 'handleCallback'])->name('slack.callback');
    Route::get('/auth/slack/disconnect', [App\Http\Controllers\SlackConnectController::class, 'disconnect'])->name('slack.disconnect');
    Route::put('/slackconnect/{slack_connect}', [App\Http\Controllers\SlackConnectController::class, 'update'])->name('slack.update');
    Route::delete('/slackconnect/{slack_connect}', [App\Http\Controllers\SlackConnectController::class, 'destroy'])->name('slack.destroy');

    #Pushover redirect routes
    Route::get('/auth/pushover/redirect', [App\Http\Controllers\PushoverConnectController::class, 'redirect'])->name('pushover.redirect');
    Route::get('/auth/pushover/callback', [App\Http\Controllers\PushoverConnectController::class, 'handleCallback'])->name('pushover.callback');
    Route::get('/auth/pushover/disconnect', [App\Http\Controllers\PushoverConnectController::class, 'disconnect'])->name('pushover.disconnect');
    Route::put('/pushoverconnect/{pushover_connect}', [App\Http\Controllers\PushoverConnectController::class, 'update'])->name('pushover.update');
    Route::delete('/pushoverconnect/{pushover_connect}', [App\Http\Controllers\PushoverConnectController::class, 'destroy'])->name('pushover.destroy');
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
