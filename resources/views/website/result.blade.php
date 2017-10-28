@extends('website.layouts.app')

@section('title', 'Result')

@section('content')


    @include('website.includes.navigation', [
   'logo' => 'img/toggle.svg',
   'homepage' => false
   ])


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="blockResultHeading" style="margin-top: 150px;">Overview
                    <small>{{$response->technologies->url}}</small>
                </h2>
            </div>
        </div>

        <div class="row blockOverview">

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Powered By</h5>
                        <span class="application">
                            @if (!$response->application)
                                Unknown
                            @elseif(in_array('wordpress',$response->application))
                                WordPress
                            @else
                                {{implode(', ',$response->application)}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            @if (in_array('wordpress',$response->application))
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="media p-t-30 p-b-30">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Theme</h5>
                            <span class="application">
                            @if ($response->theme)
                                    @foreach($response->theme as $theme=>$detail)
                                        {{ucfirst($theme)}}
                                        <br/>
                                    @endforeach
                                @else
                                    Custom Theme
                                @endif
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            @if ($response->plugins)
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="media p-t-30 p-b-30">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Plugins</h5>
                            <span class="application">
                             @if (count($response->plugins)>0)
                                    {{count($response->plugins)}}
                                @else
                                    0
                                @endif
                        </span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Technologies</h5>
                        <span class="application">
                            @if (count(array_collapse($response->technologies->applications))>0)
                                {{count(array_collapse($response->technologies->applications))}}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>

        </div>
        @if ($response->plugins)
            <div class="row">
                <div class="col-md-12">
                    <h2 class="blockResultHeading">WordPress Plugins</h2>
                </div>
            </div>
            <div class="row blockSummary">
                <div class="col-md-12">
                    <p class="blockSummary__p">www.darktips.com seems to be running WordPress. We have been able to
                        identify @if (count($response->plugins)>0) {{count($response->plugins)}} @else 0 @endif
                        plugins.
                    </p>
                </div>
            </div>

            <div class="row blockPlugins">

                @foreach ($response->plugins as $key=>$plugin)

                    @php
                        $colors = ['grey','blue','orange','dark-grey','green'];
                        $randomColors = array_rand($colors, 1);
                        $color = $colors[$randomColors];
                    @endphp
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="blockPlugins__plugin">
                            <h4>
                                <span class="blockPlugins__pluginBadge {{$color}}">{{substr(ucfirst($plugin->name),0,1)}}</span>{{str_limit(ucfirst($plugin->name),20)}}
                            </h4>
                            <p class="blockPlugins__muted">
                                @if(!is_null($plugin->description))
                                    {{str_limit(ucfirst($plugin->description),95)}}
                                @else
                                    No description found for this plugin.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if (count($response->technologies->applications)>0)
            <div class="row">
                <div class="col-md-12 blockSummary">
                    <h2 class="blockResultHeading">Technologies</h2>
                    <p class="blockSummary__p">We have only just begun uncovering technologies. Here's what we found so
                        far.</p>
                </div>
            </div>

            <div class="row">
                @foreach ($response->technologies->applications as $category=>$applications)

                    @foreach ($applications as $application)
                        <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                            <div class="col-md-4 col-sm-3 col-xs-4">
                                <img src="{{asset('img/slack.svg')}}" alt="Slack">
                            </div>
                            <div class="col-md-8 col-sm-9 col-xs-8">
                                <div class="blockTechnologies__technology-information">
                                    <h5> {{ucfirst($application->name)}} {{$application->version}}</h5>
                                    <h5>{{$category}}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>
@endsection
