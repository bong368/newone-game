<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $game_name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="game-wrapper">
    <div id="game"></div>
</div>
<script>
    function getConfig() {
        return {
            gameUrl: 'http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}',
            gameName: '{{ $game_name }}',
            gameCulture: '{{ $culture }}',
            gameFileToken: '{{ $game_token }}',
            serverUrl: '{{ $server_url }}',
            serverPort: '{{ $server_port }}',
            accessToken: '{{ $access_token }}'
        };
    }

    function returnToLobby() {
        window.close();
    }

    $(document).ready(function () {

    });
</script>
<script src="http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}/Core.js?v={{ $game_token }}"></script>
<script src="http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}/UILoader.js?v={{ $game_token }}"></script>
<script src="http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}/UISystem.js?v={{ $game_token }}"></script>
<script src="http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}/UIAssets.js?v={{ $game_token }}"></script>
<script src="http://d21wzngo3harup.cloudfront.net/swf/{{ $game_name }}/Main.js?v={{ $game_token }}"></script>
</body>
</html>
