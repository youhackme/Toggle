<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
    <meta name="description"
          content="Find out what WordPress themes, plugins, applications, frameworks, technologies  your favorite sites are using!">
</head>
<body>


@yield('content')


<script src="{{mix('js/app.js')}}"></script>
</body>
</html>