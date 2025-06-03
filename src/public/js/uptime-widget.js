(function() {
    function renderBars(data) {
        var container = document.getElementById('uptime-bars');
        if (!container) return;
        container.innerHTML = '';
        for (var i = 0; i < 20; i++) {
            var bar = document.createElement('div');
            var status = data && data[i] !== undefined && data[i] !== null ? data[i] : null;
            bar.className = 'bar' +
                (status === 1 ? ' up' : status === 0 ? ' down' : '');
            bar.title = status === 1 ? 'Up' : status === 0 ? 'Down' : 'No Data';
            container.appendChild(bar);
        }
    }

    function initEcho() {
        var EchoClass = window.Echo.default ? window.Echo.default : window.Echo;
        window.EchoInstance = new EchoClass({
            broadcaster: 'reverb',
            key: window.reverbKey,
            wsHost: 'appsare.com',
            wsPort: 443,
            wssPort: 443,
            forceTLS: true,
            enabledTransports: ['ws', 'wss'],
        });

        window.EchoInstance.channel('tracker-uptime.' + window.trackerId)
            .listen('App\\Events\\TrackerUptimeUpdated', function(e) {
                renderBars(e.uptimeData);
            });
    }

    // Initial render: all gray bars
    renderBars(window.initialUptimeData);

    // Initialize Echo
    if (!window.EchoInstance) {
        initEcho();
    }
})();