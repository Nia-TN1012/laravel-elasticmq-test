<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix( "css/app.css" ) }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <title>Laravel × ElasticMQ TEST</title>
    </head>
    <body>
        <div class="container-fluid">
            <h1>Laravel × ElasticMQ TEST</h1>
            <div class="my-5"></div>

            <div id="job-list">
                <job-list-component></job-list-component>
            </div>
        </div>

        <script src="{{ mix( "js/manifest.js" ) }}"></script>
        <script src="{{ mix( "js/vendor.js" ) }}"></script>
        <script src="{{ mix( "js/app.js" ) }}"></script>
    </body>
</html>
