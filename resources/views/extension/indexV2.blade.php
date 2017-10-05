<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toggle.me</title>

    <!-- Fonts
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">


    <style>

    </style>
    <style>
        html, body {
            font-family: 'Proxima Nova', sans-serif;
        }

        a:focus, a:hover {
            text-decoration: none;
        }

        h4 {
            color: #7A7A7A;
        }

        dt {
            font-family: 'proxima_nova_ltsemibold', sans-serif;
            font-weight: 500;
        }

        dl dd {

            color: #7A7A7A;
            font-weight: 500;
        }

        div.overview h4 small {
            background-color: #7774E7;
            color: #FFFFFF;
            padding: 3px 5px;
            font-weight: 300;
        }

        div.plugins span.badge, div.technologies span.badge {
            background-color: #5BC739;
            font-weight: 100;
        }

        ul.plugins, ul.plugins li {
            list-style: none;
            margin: 0;
            padding: 0;
            color: #7A7A7A;
            font-weight: 500;
        }

        ul.plugins {
            width: 100%;
        }

        ul.plugins li {
            float: left;
            width: 33.33%;
            margin-top: 7px;
            text-align: left;
        }

        ul.plugins li:hover {
            background-color: red;
            cursor: pointer;
        }

        .row.grid {
            column-width: 19em;
            -moz-column-width: 19em;
            -webkit-column-width: 19em;
            column-gap: 1em;
            -moz-column-gap: 1em;
            -webkit-column-gap: 1em;
        }

        .item {
            display: inline-block;
            width: 100%;
        }

        .well {
            margin-bottom: 0;
            padding: 15px;
        }

        div.item ul {
            text-align: left;
            list-style-type: none;
            padding: 0;
            color: #7A7A7A;
        }

        div.item ul li {
            margin-top: 7px;
        }

        .color {
            color: #7774E6;
        }

        .well {
            margin-bottom: 0;
            background-color: transparent;
            border: none;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding: 0px 15px 0 15px;

        }

        div.item h5 {
            font-weight: 600;
        }

        .m-top-10 {
            margin-top: 10px;
        }

    </style>
</head>
<body>
<div class="container-fluid extension-wrapper">

    <div class="overview">
        <div class="row">
            <div class="col-md-12">
                <h4>Overview
                    <small>{{$response->technologies->url}}</small>
                </h4>
            </div>
        </div>
        <div class="row m-top-10">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Application</dt>
                    <dd>
                        @if (!$response->application)
                            Unknown
                        @else
                            {{strtoupper($response->application)}}
                        @endif
                    </dd>
                </dl>
            </div>
            @if (strtolower($response->application)=='wordpress')
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <dl>
                        <dt>Theme name</dt>
                        <dd>
                            @if ($response->theme)
                                @foreach($response->theme as $theme=>$detail)
                                    {{ucfirst($theme)}}
                                @endforeach
                            @else
                                Custom Theme
                            @endif
                        </dd>
                    </dl>
                </div>
            @endif
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Plugins</dt>
                    <dd>
                        @if (count($response->plugins)>0)
                            {{count($response->plugins)}}
                        @else
                            0
                        @endif
                    </dd>
                </dl>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Technologies</dt>
                    <dd>
                        @if (count($response->technologies->applications)>0)
                            {{count($response->technologies->applications)}}
                        @else
                            0
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

    </div>

    <div class="plugins m-top-10">
        <div class="row">
            <div class="col-md-12">
                <h4>WordPress Plugins
                    <span class="badge">
                         @if (count($response->plugins)>0)
                            {{count($response->plugins)}}
                        @else
                            0
                        @endif
                    </span>
                </h4>
            </div>
        </div>
        @if ($response->plugins)
            <div class="row">
                <div class="col-md-12">
                    <ul class="plugins">
                        @foreach ($response->plugins as $key=>$plugin)
                            <li>{{ucfirst($plugin->name)}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>


    <div class="technologies" style="margin-top: 25px;">
        <div class="row">
            <div class="col-md-12">
                <h4>Technologies
                    <span class="badge">
                        @if (count($response->technologies->applications)>0)
                            {{count($response->technologies->applications)}}
                        @else
                            0
                        @endif
                    </span>
                </h4>
            </div>
        </div>

        @if (count($response->technologies->applications)>0)
            <div class="row grid">
                <div class="item well">

                    @foreach ($response->technologies->applications as $category=>$applications)
                        <h5 class="color">{{$category}}</h5>
                        <ul>
                            @foreach ($applications as $application)
                                <li>{{ucfirst($application->name)}}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

</body>
</html>
