<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $game_name }}</title>
    <link href="{{ asset('css/normalize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('swfobject-2.2/swfobject.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="game-wrapper">
    <div id="game"></div>
</div>
<script>
    function startGame() {
        if (!isFlashPlayerInstalled()) {
            window.location = 'https://get.adobe.com/tw/flashplayer';
            return;
        }

        var loader = 'http://d21wzngo3harup.cloudfront.net/swf/proloader.swf?v={{ $loader_token }}';
        var flashvars = {
            gameUrl: 'http://d21wzngo3harup.cloudfront.net/swf',
            gameName: '{{ $game_name }}',
            gameCulture: '{{ $culture }}',
            gameFileToken: '{{ $game_token }}',
            serverUrl: '{{ $server_url }}',
            serverPort: '{{ $server_port }}',
            accessToken: '{{ $access_token }}'
        };

        embedSwf(loader, flashvars, 'game', '100%', '100%');
    }

    function returnToLobby() {
        window.close();
    }

    $(document).ready(function () {
        startGame();
    });
</script>
</body>
</html>
