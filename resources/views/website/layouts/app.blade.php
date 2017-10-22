<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body>


@yield('content')


<div class="container-fluid">
    <!-- Footer  -->
    
    <div class="row">
        <div class="col-md-12" style="text-align: center;">
            <footer>
                <small class="text-muted" style="text-transform:uppercase;"> © 2017 Toggle.me</small>
            </footer>
        </div>
    </div>

</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>