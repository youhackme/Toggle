<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Toggle</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body>

<style>

    .example3 {
        border-bottom: 1px solid #e0e0e0;
    }

    .example3 .navbar-brand {
        height: 80px;
    }

    .example3 .nav > li > a {
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .example3 .navbar-toggle {
        padding: 10px;
        margin: 25px 15px 25px 0;

    }

    .example3 .nav > li > a:hover {

        background-color: transparent;
    }

    .navbar-brand img {
        height: 50px;
    }

    .navbar-static-top {
        margin-bottom: 0px;
    }

    h2.result-heading small {
        background-color: #7774E7;
        color: #ffffff;
        padding: 4px 10px;
        vertical-align: middle;
        font-size: 23px;
        text-transform: uppercase;
    }

    h2.result-heading:first-child {
        margin-top: 80px;
    }

    h2.result-heading:not(:first-child) {
        margin-top: 115px;
    }

    h2.result-heading {
        font-family: "Proxima Nova Semibold";
        color: #333333;

    }

    p.summary {
        font-size: 16px;
    }

    div.plugins {
        border: 1px solid #ECECEC;
        padding: 20px;
        margin-bottom: 30px;
    }

    div.plugins h4 {
        font-family: "Proxima Nova Semibold";
        color: #333333;
    }

    p.description {
        color: #333333;
        opacity: 0.6;
    }

    .plugin-badge {
        font-family: "Proxima Nova";
        width: 25px;
        height: 25px;
        border-radius: 50%;
        font-size: 13px;
        color: #fff;
        line-height: 27px;
        text-align: center;
        vertical-align: middle;
        display: inline-block;
        margin-right: 10px;
    }

    .plugin-badge.grey {
        background-color: grey;
    }

    .plugin-badge.light-blue {
        background-color: grey;
    }

    .plugin-badge.grey {
        background-color: #46B9D8;
    }

    .plugin-badge.orange {
        background-color: #F67700;
    }

    .plugin-badge.blue {
        background-color: #2F84ED;
    }

    .plugin-badge.dark-grey {
        background-color: #424242;
    }

    .plugin-badge.green {
        background-color: #0ACF78;
    }

    div.technologies {
        margin-bottom: 30px;
    }

    h5.media-heading {
        text-transform: uppercase;
    }

    span.application {
        font-family: "Proxima Nova Semibold";
        font-size: 15px;
    }

    div.overview-details {
        margin-top: 10px;
    }


</style>

<div class="container-fluid">
    <div class="row">
        <div class="example3">
            <nav class="navbar  navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar3">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="https://toggle.me">
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

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="result-heading">Overview
                <small>stella-telecom.fr</small>
            </h2>
        </div>
    </div>

    <div class="row overview-details">

        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="media p-t-30 p-b-30">
                <div class="media-left">
                    <a href="#">
                        <img src="{{asset('img/wordpress.svg')}}" alt="WordPress">
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
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
                <div class="media-body" style="vertical-align: middle;">
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
                <div class="media-body" style="vertical-align: middle;">
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
                <div class="media-body" style="vertical-align: middle;">
                    <h5 class="media-heading">Technologies</h5>
                    <span class="application">19</span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="result-heading">WordPress Plugins</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="summary description">www.darktips.com seems to be running WordPress. We have been able to
                identified 6
                plugins.</p>
        </div>
    </div>


    <div class="row" style="margin-top:15px;">

        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge grey">M</span>Mailchimp</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge light-blue">H</span>Hubspot</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge orange">Y</span>Yopto</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge blue">W</span>Woocommerce</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge dark-grey">H</span>Hubspot</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge green">M</span>Mailchimp</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge grey">W</span>Woocommerce</h4>
                <p class="description">Email marketing service for managing contacts, sending emails, and tracking
                    results.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="plugins">
                <h4><span class="plugin-badge orange">Y</span>Yopto</h4>
                <p class="description">
                    Email marketing service for managing contacts, sending emails, and tracking results.
                </p>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-12">
            <h2 class="result-heading">Technologies</h2>
            <p class="summary description">We have only just begun uncovering technologies. Here's what we found so
                far.</p>
        </div>
    </div>

    <div class="row" style="margin-top:15px;">
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 technologies">
            <div class="col-md-4 col-sm-3 col-xs-4">
                <img src="{{asset('img/slack.svg')}}" alt="Slack">
            </div>
            <div class="col-md-8 col-sm-9 col-xs-8">
                <div class="technology-information">
                    <h6>Slack</h6>
                    <p>Communication</p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container-fluid">
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
