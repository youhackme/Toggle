<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toggle.me</title>


    @if (!is_array($response))

        @if(isset($response->debugMode))
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
                  crossorigin="anonymous">
        @endif

    @endif


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
            padding: 5px 7px;
            font-size: 9px;
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

        .media-heading {
            font-family: 'Proxima Nova Semibold', sans-serif;
            font-weight: 600;
            color: #58585B;
        }

        img.poweredBy {
            width: 32px;
            height: 35px;
        }

    </style>
</head>
<body>
<div class="container-fluid extension-wrapper">

    @if ($response->errors===false)
        @php
            $mainApplication = false;
        @endphp
        <div class="overview">
            <div class="row">
                <div class="col-md-12">
                    <h4>Overview
                        <small>{{$response->host}}</small>
                    </h4>
                </div>
            </div>
            <div class="row m-top-10">
                <div class="col-md-4 col-sm-4 col-xs-4">


                    <div class="media">
                        <div class="media-left">
                            @foreach($response->applications as $application)
                                @if($application->poweredBy)

                                    <img class="poweredBy"
                                         src="{{$application->icon}}" alt="{{$application->name}}">
                                    @php
                                        $mainApplication = true;
                                    @endphp

                                    @break
                                @endif
                            @endforeach
                            @if (!$mainApplication)
                                <img class="poweredBy" src="{{asset('img/unknown.svg')}}"
                                     alt="{{asset('img/unknown.svg')}}">
                            @endif

                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Powered By</h5>
                            <span class="application">
                                @foreach($response->applications as $application)
                                    @if($application->poweredBy)
                                        {{$application->name}} {{isset($application->version)? $application->version:''}}
                                        @php
                                            $mainApplication = true;
                                        @endphp
                                    @endif
                                @endforeach


                                @if (!$mainApplication)
                                    Custom Application
                                @endif


                            </span>
                        </div>
                    </div>
                </div>
                @php
                    $applicationName = array_column($response->applications,'name');
                    $pluginCount = 0;
                    foreach($response->applications as $application){

                       if($application->name=='WordPress'){
                        if(!is_null($application->plugins)){
                           $pluginCount = count($application->plugins);
                        }
                        }
                    }
                @endphp

                @if(in_array('WordPress',$applicationName))
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <dl>
                            <dt>Theme</dt>
                            <dd>
                                @foreach($response->applications as $application)
                                    @if($application->name=='WordPress')
                                        @if(!is_null($application->themes))
                                            @foreach($application->themes as $theme)
                                                {{ucfirst($theme->name)}}
                                                <br/>
                                            @endforeach
                                        @else
                                            Custom Theme
                                        @endif
                                    @endif
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                @endif
                @if(in_array('WordPress',$applicationName))
                    @if (empty($response->applications['WordPress']->plugins))
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <dl>
                                <dt>Plugins</dt>
                                <dd>
                                    {{$pluginCount}}
                                </dd>
                            </dl>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @if(in_array('WordPress',$applicationName))
            @if (empty($response->applications['WordPress']->plugins))
                <div class="plugins m-top-10">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>WordPress Plugins
                                <span class="badge">
                                   {{$pluginCount}}
                                 </span>
                            </h4>
                        </div>
                    </div>
                    @foreach($response->applications as $application)
                        @if($application->name=='WordPress')
                            @if(!is_null($application->plugins))

                                @php
                                    $colors = ['grey','blue','orange','dark-grey','green'];
                                    $randomColors = array_rand($colors, 1);
                                    $color = $colors[$randomColors];
                                @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="plugins">
                                            @foreach($application->plugins as $plugin)
                                                <li class="col-md-6">{{str_limit(ucfirst($plugin->name),30)}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
        <div class="technologies" style="margin-top: 25px;">
            <div class="row">
                <div class="col-md-12">
                    <h4>Technologies
                        <span class="badge">
                            @if (count(array_collapse($response->applicationsByCategory))>0)
                                {{count(array_collapse($response->applicationsByCategory))}}
                            @else
                                0
                            @endif
                    </span>
                    </h4>
                </div>
            </div>

            @if (count($response->applicationsByCategory)>0)
                <div class="row grid">
                    @foreach ($response->applicationsByCategory as $category=>$applications)

                        @if(count($applications)==1 && $applications['0']->poweredBy)
                            @continue
                        @endif
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
    @else
        {{$response->errors}}
    @endif
</div>

@if (!is_array($response))
    @if(isset($response->debugMode))
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
    @endif
@endif

</body>
</html>
