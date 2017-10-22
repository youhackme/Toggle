@extends('website.layouts.app')

@section('title', 'Result')

@section('content')

    <div class="container-fluid">
        <div class="row blockNavigation">
            <nav class="navbar  navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar3">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{env('APP_URL')}}">
                            <img src="{{asset('img/toggle.svg')}}" alt="Logo">
                        </a>
                    </div>
                    <div id="navbar3" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="blockResultHeading" style="margin-top: 150px;">Overview
                    <small>stella-telecom.fr</small>
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
                        <span class="application">WordPress</span>
                    </div>
                </div>


            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Theme</h5>
                        <span class="application">Progressive</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Plugins</h5>
                        <span class="application">8</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="media p-t-30 p-b-30">
                    <div class="media-left">
                        <a href="#">
                            <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">Technologies</h5>
                        <span class="application">19</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <h2 class="blockResultHeading">WordPress Plugins</h2>
            </div>
        </div>
        <div class="row blockSummary">
            <div class="col-md-12">
                <p class="blockSummary__p">www.darktips.com seems to be running WordPress. We have been able to
                    identified 6
                    plugins.</p>
            </div>
        </div>


        <div class="row blockPlugins">

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge grey">M</span>Mailchimp</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge blue">H</span>Hubspot</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>

            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge orange">Y</span>Yopto</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge blue">W</span>Woocommerce</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge dark-grey">H</span>Hubspot</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge green">M</span>Mailchimp</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge grey">W</span>Woocommerce</h4>
                    <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                        results.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="blockPlugins__plugin">
                    <h4><span class="blockPlugins__pluginBadge orange">Y</span>Yopto</h4>
                    <p class="description">
                        Email marketing service for managing contacts, sending emails, and tracking results.
                    </p>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-12 blockSummary">
                <h2 class="blockResultHeading">Technologies</h2>
                <p class="blockSummary__p">We have only just begun uncovering technologies. Here's what we found so
                    far.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 blockTechnologies__technology">
                <div class="col-md-4 col-sm-3 col-xs-4">
                    <img src="{{asset('img/slack.svg')}}" alt="Slack">
                </div>
                <div class="col-md-8 col-sm-9 col-xs-8">
                    <div class="blockTechnologies__blockTechnologies__technology-information">
                        <h5>Slack</h5>
                        <h6>Communication</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
