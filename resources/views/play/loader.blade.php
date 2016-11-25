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
            $('#game').html('<a href="https://get.adobe.com/tw/flashplayer" target="_blank">你沒有安裝 Flash Player，請點我前往安裝</a>');
            return;
        }

        var loader = 'http://igdev.ricogaming.net:81/games/loader.swf?v={{ $loader_token }}';
        var flashvars = {
            GameUrl: 'http://igdev.ricogaming.net:81/games',
            GameName: '{{ $game_name }}',
            Token: '{{ $game_token }}',
            Width: '{{ $game_width }}',
            Height: '{{ $game_height }}',
            Culture: '{{ $culture }}',
            Ip: '{{ $server_url }}',
            Port: '{{ $server_port }}',
            SessionId: '{{ $access_token }}',
            Account: '{{ $account }}'
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
