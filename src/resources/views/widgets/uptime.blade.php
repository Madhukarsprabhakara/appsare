{{-- resources/views/widgets/uptime.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Uptime Widget</title>
    <style>
        body { margin:0; background:transparent; }
        #uptime-bars { display: flex; gap: 2px; align-items: flex-end; }
        .bar { width: 6px; height: 28px; border-radius: 2px; background: #a3a3a3; transition: background 0.2s; }
        .bar.up { background: #22c55e; }
        .bar.down { background: #ef4444; }
    </style>
</head>
<body>
    <div id="uptime-bars"></div>
    <script>
        window.trackerId = "{{ $trackerId }}";
        // 20 nulls for default gray bars
        window.initialUptimeData = @json($uptimeData ?? array_fill(0, 20, null));
        window.reverbKey = "{{ config('broadcasting.connections.reverb.key') }}";
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script src="/js/uptime-widget.js"></script>
</body>
</html>