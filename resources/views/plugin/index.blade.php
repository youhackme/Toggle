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
            margin: .75rem;
        }

        .button {
            align-items: center;
            border-radius: 3px;
            box-shadow: none;
            display: inline-flex;
            font-size: 1rem;
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


    </style>
</head>
<body>

<div class="container-fluid" style="height:460px;">
    <div class="row">
        <div style="background-color: #ffffff;padding-right:0;padding-left: 0;height:460px;border-right:1px solid red"
             class="col-xs-5">
            <ul class="list-group">
                <li class="list-group-item" style="border:none;">
                    <h6 class="panel-title"
                        style="text-transform: uppercase;font-size: 12px;font-weight: normal;">
                        Domain
                    </h6>
                    <h4>
                        <!--  <img class="favicon animated fadeIn"
                               src="//www.google.com/s2/favicons?domain=w3schools.com">-->
                        www.darktips.com
                    </h4>

                </li>
                <li class="list-group-item" style="border:none;">
                    <h6 class="panel-title"
                        style="text-transform: uppercase;font-size: 12px;font-weight: normal;">
                        Application
                    </h6>
                    <h4>
                        WordPress
                    </h4>
                </li>
                <li class="list-group-item" style="border:none;">
                    <h6 class="panel-title"
                        style="text-transform: uppercase;font-size: 12px;font-weight: normal;">
                        Theme name
                    </h6>
                    <h4>
                        Progressive Theme
                    </h4>
                </li>
                <li class="list-group-item" style="border:none;">
                    <h6 class="panel-title"
                        style="text-transform: uppercase;font-size: 12px;font-weight: normal;">
                        Technologies found
                    </h6>
                    <h4>
                        17
                    </h4>
                </li>
            </ul>
        </div>
        <div style="background: #cccccc;padding-right:0;padding-left: 0;height:460px" class="col-xs-7">
            <div class="panel-group" id="plugins" style="margin-bottom:0px;">
                <div class="panel panel-default">
                    <div class="panel-heading"
                         style="background-color: #EBEDF0;cursor: pointer;">
                        <h4 class="panel-title">
                            <a>WordPresss Plugins</a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in">
                        <div class="panel-body" style="padding:0px;">
                            <table class="table table-bordered" style="margin-bottom:0px;border:none;">
                                <tbody>
                                <tr>
                                    <td style="border:none;">

                                        <div class="wrapper">
                                            <div class="pull-left" style="padding-right: 15px;padding-top:10px;">
                                                <span class="circle">
                                                  G
                                                </span>
                                            </div>
                                            <div class="pull-left">
                                                <h5 style="margin-bottom: 0px;">Google Analytics</h5>
                                                <small>Track visitors on your website.</small>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <tr style="background-color:#fafafa;">
                                    <td style="border:none;">

                                        <div class="wrapper">
                                            <div class="pull-left" style="padding-right: 15px;padding-top:10px;">
                                                <span class="circle">
                                                  P
                                                </span>

                                            </div>
                                            <div class="pull-left">
                                                <h5 style="margin-bottom: 0px;">Piwik</h5>
                                                <small>Track visitors on your website.</small>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:none;">

                                        <div class="wrapper">
                                            <div class="pull-left" style="padding-right: 15px;padding-top:10px;">
                                                <span class="circle">
                                                  K
                                                </span>

                                            </div>
                                            <div class="pull-left">
                                                <h5 style="margin-bottom: 0px;">Kissmetrics</h5>
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
            <div class="panel-group" id="technologies" style="margin-bottom:0px;">
                <div class="panel panel-default">
                    <div class="panel-heading"
                         style="background-color: #EBEDF0;cursor: pointer;">
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
