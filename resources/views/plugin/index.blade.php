<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toggle.me</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html, body {
            font-family: 'Lato', sans-serif;
        }

        a:focus, a:hover {
            text-decoration: none;
        }

        span.circle {

            display: block;
            height: 30px;
            width: 30px;
            line-height: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
            background-color: #C36497;
            color: white;
            text-align: center;
            font-size: 18px;
        }

        .button.application {
            margin: 5px 0px 0px 5px;
        }

        .button {
            align-items: center;
            border-radius: 3px;
            box-shadow: none;
            display: inline-flex;
            font-size: 12px;
            height: 2.285em;
            position: relative;
            vertical-align: top;
            user-select: none;
            border: 1px solid #dbdbdb;
            cursor: pointer;
            justify-content: center;
            padding-left: .75em;
            padding-right: .75em;
            text-align: center;
            color: #4a4a4a;
            line-height: 1.5;
        }

        .app-icon {
            height: 16px;
            margin-right: .5rem;
            overflow: hidden;
            width: 16px;
            vertical-align: baseline;
        }

        .panel-default {
            border-color: #ffffff;
        }

        .panel {
            box-shadow: none;
            border: none;
            border-radius: 0;
        }

        .panel-heading {
            background-color: #F7F8FB !important;
        }

        .panel-body {
            padding: 0px;
        }

        h6.panel-title {
            color: #b3b3b3;
        }

        div.panel-group {
            margin-bottom: 0px;
        }

        li.list-group-item h5 {
            margin-bottom: 5px;
        }

        .extension-wrapper {
            height: 460px;
        }

        div.overview {
            background-color: #ffffff;
            padding-right: 0;
            padding-left: 0;
            height: 460px;
            border-right: 1px solid #C9D2D5
        }

        div.overview li {
            border: none;
        }

        div.overview li h6 {
            text-transform: uppercase;
            font-size: 12px;
            font-weight: normal;
        }

        div.details {
            background: #ffffff;
            padding-right: 0;
            padding-left: 0;
            height: 460px;
        }

        table.table {
            margin-bottom: 0px;
            border: none;
        }

        div.icon-holder {
            padding-right: 15px;
            padding-top: 10px;
        }

        div.plugin-details h5 {
            margin-bottom: 0px;
        }

        tr.zebra-color {
            background-color: #fafafa;
        }

        tr > td {
            border: none !important;
        }
    </style>
</head>
<body>

<div class="container-fluid extension-wrapper">
    <div class="row">
        <div class="col-xs-5 overview">
            <ul class="list-group">
                <li class="list-group-item">
                    <h6 class="panel-title">
                        Domain
                    </h6>
                    <h5>
                        <img class="favicon animated fadeIn"
                             src="https://www.google.com/s2/favicons?domain=w3schools.com">
                        www.darktips.com
                    </h5>

                </li>
                <li class="list-group-item">
                    <h6 class="panel-title">
                        Application
                    </h6>
                    <h5>
                        WordPress
                    </h5>
                </li>
                <li class="list-group-item">
                    <h6 class="panel-title">
                        Theme name
                    </h6>
                    <h5>
                        Progressive Theme
                    </h5>
                </li>
                <li class="list-group-item">
                    <h6 class="panel-title">
                        Technologies found
                    </h6>
                    <h5>
                        17
                    </h5>
                </li>
            </ul>
        </div>
        <div class="col-xs-7 details">
            <div class="panel-group" id="plugins">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>WordPresss Plugins</a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>

                                        <div class="wrapper">
                                            <div class="icon-holder pull-left">
                                                <span class="circle">
                                                  G
                                                </span>
                                            </div>
                                            <div class="plugin-details pull-left">
                                                <h5>Google Analytics</h5>
                                                <small>Track visitors on your website.</small>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <tr class="zebra-color">
                                    <td>

                                        <div class="wrapper">
                                            <div class="icon-holder pull-left">
                                                <span class="circle">
                                                  P
                                                </span>

                                            </div>
                                            <div class="plugin-details pull-left">
                                                <h5>Piwik</h5>
                                                <small>Track visitors on your website.</small>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <div class="wrapper">
                                            <div class="icon-holder pull-left">
                                                <span class="circle">
                                                  K
                                                </span>

                                            </div>
                                            <div class="plugin-details pull-left">
                                                <h5>Kissmetrics</h5>
                                                <small>Track visitors on your website.</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-group" id="technologies">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>Technologies</a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in">
                        <div class="panel-body" style="padding:0px;">
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                            <a class="button application" href="/applications/adinfinity">
                                <img class="app-icon" src="https://wappalyzer.com/images/icons/AdInfinity.png"
                                     alt="AdInfinity">
                                AdInfinity
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script>
  $(function () {

  });


</script>

</body>
</html>
