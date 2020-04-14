<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Weather app</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">
        <script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1" defer></script>
        <script src="/js/app.js" defer> </script>
        <!-- Styles -->
    </head>

    <body class="bg-gray-300">
        <div id="app" class="flex justify-center pt-16">
            <weather-app></weather-app>
        </div>
    </body>
</html>
