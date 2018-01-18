@extends('website.layouts.app')

@section('title','Technologies used by '. $response->url)

@section('content')


    @include('website.includes.navigation', [
   'logo' => 'img/logoBlackOnWhite.svg',
   'homepage' => false
   ])

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="blockResultHeading" style="margin-top: 150px;">Overview
                    <small>{{$response->host}}</small>
                </h2>
            </div>
        </div>

        <div class="row blockOverview">

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            @php
                                $mainApplication = false;
                            @endphp


                            @foreach($response->applications as $application)
                                @if($application->poweredBy)
                                    <img class="blockOverview__iconSize" src="{{$application->icon}}"
                                         alt="{{$application->name}}">
                                    @php
                                        $mainApplication = true;
                                    @endphp
                                    @break
                                @endif
                            @endforeach

                            @if (!$mainApplication)
                                <img class="blockOverview__iconSize" src="{{asset('img/unknown.svg')}}"
                                     alt="{{asset('img/unknown.svg')}}">
                            @endif

                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Powered By</h5>
                        <span class="application">
                            @if (!$mainApplication)
                                Unknown
                            @else
                                @foreach($response->applications as $application)
                                    @if($application->poweredBy)
                                        {{$application->name}} {{isset($application->version)? $application->version:''}}
                                    @endif
                                @endforeach
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
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="media p-t-30 p-b-30">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{asset('img/theme.svg')}}" alt="WordPress">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Theme</h5>
                            <span class="application">

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
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            @if(in_array('WordPress',$applicationName))

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="media p-t-30 p-b-30">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{asset('img/plugin.svg')}}" alt="WordPress">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Plugins</h5>
                            <span class="application">
                                    {{$pluginCount}}
                                 </span>
                        </div>
                    </div>
                </div>

            @endif
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/technology.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Technologies</h5>
                        <span class="application">
                            @if (count(array_collapse($response->applicationsByCategory))>0)
                                {{count(array_collapse($response->applicationsByCategory))}}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>

        </div>

        @if(in_array('WordPress',$applicationName))
            @if($pluginCount>0)
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="blockResultHeading">WordPress Plugins</h2>
                    </div>
                </div>
                <div class="row blockSummary">
                    <div class="col-md-12">
                        <p class="blockSummary__p">{{$response->host}} seems to be running WordPress. We
                            have been able to identify
                            {{$pluginCount}}
                            plugins.
                        </p>
                    </div>
                </div>

                <div class="row blockPlugins">

                    @foreach($response->applications as $application)
                        @if($application->name=='WordPress')
                            @if(!is_null($application->plugins))
                                @foreach($application->plugins as $plugin)
                                    @php
                                        $colors = ['grey','blue','orange','dark-grey','green'];
                                        $randomColors = array_rand($colors, 1);
                                        $color = $colors[$randomColors];
                                    @endphp
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="blockPlugins__plugin">
                                            <h5>
                                        <span class="blockPlugins__pluginBadge {{$color}}">
                                           {{substr(ucfirst($plugin->name),0,1)}}
                                        </span>
                                                {{str_limit(ucfirst($plugin->name),45)}}
                                            </h5>
                                            <p class="blockPlugins__muted">
                                                @if(!is_null($plugin->description))
                                                    {{str_limit(ucfirst($plugin->description),130)}}
                                                @else
                                                    No description found for this plugin.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                </div>

            @endif
        @endif

        @if (count($response->applicationsByCategory)>0)
            <div class="row">
                <div class="col-md-12 blockSummary">
                    <h2 class="blockResultHeading">Technologies</h2>
                    <p class="blockSummary__p">We have only just begun uncovering technologies. Here's what we found so
                        far.</p>
                </div>
            </div>

            <div class="row">

                @foreach ($response->applicationsByCategory as $category=>$applications)
                    @foreach ($applications as $application)
                        @if(!$application->poweredBy)
                            <div class="col-md-3 col-sm-6 col-xs-12 blockTechnologies__technology">
                                <div class="col-md-4 col-sm-3 col-xs-4 blockTechnologies__outericon">
                                    <a href="{{$application->website}}" target="_blank">
                                        <img src="{{$application->icon}}"
                                             class="img-responsive blockTechnologies__innericon"
                                             alt="{{ucfirst($application->name)}} {{$application->version}}">
                                    </a>
                                </div>
                                <div class="col-md-8 col-sm-9 col-xs-8">
                                    <div class="blockTechnologies__technology-information">
                                        <a href="{{$application->website}}" target="_blank">
                                            <h5> {{ucfirst($application->name)}} {{$application->version}}</h5>
                                        </a>
                                        <h5>{{$category}}</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>


    <footer class="footer">
        <div class="container">
            <small class="text-muted"> © {{ Carbon\Carbon::now()->format('Y') }} Toggle.me</small>
        </div>
    </footer>


@endsection


