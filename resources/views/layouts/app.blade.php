


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> -->
    <script src='https://www.gstatic.com/charts/loader.js'></script>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="antialiased">
<div id='app'>
    
    <heade></heade>
    <div class='select'>
        <selection></selection>
        <!-- <heatmap></heatmap> -->
    </div>
    <foote></foote>
</div>


</body>
</html>
