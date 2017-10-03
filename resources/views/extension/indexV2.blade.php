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
                    <small>https://darktips.com</small>
                </h4>
            </div>
        </div>
        <div class="row m-top-10">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Application</dt>
                    <dd>WordPress</dd>
                </dl>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Theme name</dt>
                    <dd>Progressive</dd>
                </dl>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Plugins</dt>
                    <dd>12</dd>
                </dl>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <dl>
                    <dt>Technologies</dt>
                    <dd>14</dd>
                </dl>
            </div>
        </div>

    </div>

    <div class="plugins m-top-10">
        <div class="row">
            <div class="col-md-12">
                <h4>WordPress Plugins
                    <span class="badge">12</span>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="plugins">
                    <li>Akismet</li>
                    <li>Slider Revolution</li>
                    <li>Royal Slider</li>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                    <li>WPForms</li>
                    <li>Sucuri</li>
                    <li>W3 Total Cache</li>
                    <li>Jetpack</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="technologies" style="margin-top: 25px;">
        <div class="row">
            <div class="col-md-12">
                <h4>Technologies
                    <span class="badge">15</span>
                </h4>
            </div>
        </div>


        <div class="row grid">
            <div class="item well">
                <h5 class="color">Analytics</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                    <li>WPForms</li>
                    <li>Sucuri</li>
                    <li>W3 Total Cache</li>
                    <li>Jetpack</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Chat</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Javascript Libraries</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>

                </ul>
            </div>
            <div class="item well">
                <h5 class="color">CMS</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                    <li>WPForms</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Web Server</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Tracking</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>Sucuri</li>
                    <li>W3 Total Cache</li>
                    <li>Jetpack</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Another One</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Analytics</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                    <li>WPForms</li>
                    <li>Sucuri</li>
                    <li>W3 Total Cache</li>
                    <li>Jetpack</li>
                    <li>Sucuri</li>
                    <li>W3 Total Cache</li>
                    <li>Jetpack</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Security</h5>
                <ul>
                    <li>Visual Composer</li>
                    <li>BackupBuddy</li>
                    <li>OptinMonster</li>
                    <li>WPForms</li>
                    <li>WPForms</li>
                </ul>
            </div>
            <div class="item well">
                <h5 class="color">Marketing</h5>
                <ul>
                    <li>Visual Composer</li>
                </ul>
            </div>
        </div>
    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

</body>
</html>
