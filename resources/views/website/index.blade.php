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
    .input-xlg {
        height: 56px;
        padding: 10px 16px;
        font-size: 20px;
        line-height: 1.3333333;
        border-radius: 6px;
        border: 1px solid #ffffff;
    }

    .btn-search {
        background-color: #3ecf8e;
        border: 2px solid #ffffff;
        color: #ffffff;
    }

    .btn-search:hover {
        background-color: #59d69e;
        border: 2px solid #ffffff;
        color: #ffffff;
    }

    .wrapper {
        background-color: #6772E5;
        height: calc(100vh - 50px);

    }

    .headline {
        color: #ffffff;
        text-align: center;
        padding-bottom: 20px;
        margin-top: 100px;
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

    .navbar-brand img {
        height: 50px;
    }

    .navbar-static-top {
        margin-bottom: 0px;
    }

    input[type="text"], textarea, input[type="text"]:focus, textarea:focus {
        outline: none;
        box-shadow: none !important;
        border: 1px solid #ffffff !important;
    }

    .headline {
        font-family: "Proxima Nova Thin";
    }

    span.typed {
        border-bottom: 4px solid #82B541;
        transition: border-color .3s ease-in-out;
        font-weight:bold;
    }

    .typed-cursor {
        opacity: 1;
        animation: blink .7s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
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
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </nav>
        </div>

    </div>
    <div class="row">
        <div class="wrapper">
            <div class="col-md-offset-2 col-md-8">
                <h2 class="headline">
                    Find out what
                    <span class="typed"></span>
                    your favorite sites
                    are using!
                </h2>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <div class="innerwrapper" style="margin-top:100px;">
                    <form role="form" style="margin-top:50px;">
                        <div class="input-group">
                            <input type="text" class="form-control input-xlg" placeholder="https://toggle.me">
                            <span class="input-group-btn">
                      <button class="btn btn-default btn-search input-xlg" type="button">SEARCH </button>
                    </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="background-color:yellow;">
            <footer>
                This is a footer
            </footer>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script>
  $(function () {
    new Typed('.typed', {
      strings: ['Technologies', 'WordPress Theme', 'WordPress Plugins'],
      typeSpeed: 100,
      loop: true,
      startDelay: 1000,
      backDelay: 1500
    });

  });
</script>
</body>
</html>
