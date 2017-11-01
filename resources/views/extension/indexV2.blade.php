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


    <link href="{{asset('css/font.css')}}" rel="stylesheet">

    <style>
        html, body {
            font-family: 'Proxima Nova', sans-serif;
        }

        a:focus, a:hover {
            text-decoration: none;
        }

        div.extension-wrapper {
            padding-top: 25px;
            padding-bottom: 25px;
        }

        h4 {
            color: #7A7A7A;
        }

        dt {
            font-family: 'Proxima Nova Semibold', sans-serif;
            font-weight: 600;
            color: #58585B;
        }

        dl dd {

            color: #7A7A7A;
            font-weight: 500;
        }

        div.overview h4 small {
            background-color: #7774E7;
            color: #FFFFFF;
            padding: 5px 10px;
            font-weight: 300;
        }

        div.plugins span.badge, div.technologies span.badge {
            font-family: "Proxima Nova Thin";
            background-color: #5BC739;
            font-weight: 100;
            padding: 3px 5px;
        }

        ul.plugins, ul.plugins li {
            font-family: "Proxima Nova Thin";
            list-style: none;
            margin: 0;
            padding: 0;
            color: #7A7A7A;
            font-weight: bold;
        }

        ul.plugins {
            width: 100%;
        }

        ul.plugins li {
            float: left;
            width: 50%;
            margin-top: 15px;
            text-align: left;
        }

        /*ul.plugins li:hover {*/
        /*background-color: red;*/
        /*cursor: pointer;*/
        /*}*/

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
            font-family: "Proxima Nova Thin";
            font-weight: bold;
            margin-top: 15px;

        }

        .color {
            color: #58585B;
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
            font-family: "Proxima Nova Semibold";
            font-weight: 600;
        }

        .m-top-10 {
            margin-top: 10px;
        }

        img.applicationIcon {
            max-width: 20px;
            max-height: 20px;
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
            <div class="col-md-4 col-sm-4 col-xs-4">
                <dl>
                    <dt>Powered By</dt>
                    <dd>
                        @if (!$response->application)
                            Unknown
                        @else
                            @foreach($response->application as $application)
                                {{$application['name']}}
                                @break
                            @endforeach
                        @endif
                    </dd>
                </dl>
            </div>
            @if (in_array('wordpress',$response->application))
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <dl>
                        <dt>Theme name</dt>
                        <dd>
                            @if ($response->theme)
                                @foreach($response->theme as $theme=>$detail)
                                    {{ucfirst($theme)}}
                                    <br/>
                                @endforeach
                            @else
                                Custom Theme
                            @endif
                        </dd>
                    </dl>
                </div>
            @endif
            @if ($response->plugins)
                <div class="col-md-4 col-sm-4 col-xs-4">
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
            @endif
        </div>

    </div>

    @if ($response->plugins)
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
                                <li>{{str_limit(ucfirst($plugin->name),45)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="technologies" style="margin-top: 25px;">
        <div class="row">
            <div class="col-md-12">
                <h4>Technologies
                    <span class="badge">
                        @if (count(array_collapse($response->technologies->applications))>0)
                            {{count(array_collapse($response->technologies->applications))}}
                        @else
                            0
                        @endif
                    </span>
                </h4>
            </div>
        </div>

        @if (count($response->technologies->applications)>0)
            <div class="row grid">


                @foreach ($response->technologies->applications as $category=>$applications)
                    <div class="item well">
                        <h5 class="color">{{$category}}</h5>
                        <ul>
                            @foreach ($applications as $application)
                                <li>
                                    <img src="{{$application->icon}}" class="applicationIcon"
                                         alt=""/>
                                    {{ucfirst($application->name)}} {{$application->version}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

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
