@extends('website.layouts.app')

@section('title', 'Toggle - Identify what technologies your favorite sites are using')

@section('content')

    <div class="container-fluid hexagonal-background">
        <div class="row blockNavigation blockNavigation--full js-navigation ">
            <nav class="navbar navbar-static-top">
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
                            <img src="{{asset('img/logoWhiteOnBlack.svg')}}" alt="Logo">
                        </a>
                    </div>

                {{--<div id="navbar3" class="navbar-collapse collapse">--}}
                {{--<ul class="nav navbar-nav navbar-right">--}}
                {{--<li class="active"><a href="#">How it works?</a></li>--}}
                {{--<li class="active"><a href="#">About</a></li>--}}
                {{--<li class="active"><a href="#">Blog</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </nav>
        </div>
        <!--  Headlines & Search bar  -->
        <div class="row">
            <div class="hero js-hero">
                <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
                    <h2 class="hero__headline m-t-80 p-b-20">
                        Find out what
                        <span class="typed"></span>
                        your favorite sites
                        are using!
                    </h2>
                </div>
                <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="blockSearch m-t-100">
                        <form class="m-t-50" method="get" action="/result">
                            <div class="input-group">
                                <input type="text"
                                       id="url"
                                       name="url"
                                       class="form-control input-xlg"
                                       placeholder="https://toggle.me"
                                       autofocus>
                                <span class="input-group-btn">
                      <button class="btn btn-default btn-green input-xlg"
                              type="submit">SEARCH
                      </button>
                    </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 text-center hero__section-arrow">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid explainer">
        <div class="row text-center m-t-50">
            <h1 class="explainer__title" data-parallax='{"y": -25}'>
                Identify over 1000+ Technologies across 20 categories
            </h1>
            <p class="explainer__subtitle text-muted" data-parallax='{"y": -35}'>Content Management Systems,
                Forums, eCommerce Platforms, Frameworks, you name it!
            </p>
        </div>

        <div class="col-md-offset-1 col-md-10">
            <div data-parallax='{"y": -40}' class="row">
                <div id="carousel-applications" class="carousel slide karousel" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active karousel__item">
                            <div class="col-md-4 karousel__card">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                        <h4 class="text-center">
                                            Content Management System
                                        </h4>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/wordpress.svg'}}"
                                                 alt="WordPress">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/joomla.svg'}}"
                                                 alt="Joomla!">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/drupal.svg'}}"
                                                 alt="Drupal">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/ghost.svg'}}"
                                                 alt="Ghost">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/typo3.svg'}}"
                                                 alt="Typo3">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/blogger.svg'}}"
                                                 alt="Blogger">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/wix.svg'}}"
                                                 alt="Wix">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/tumblr.svg'}}"
                                                 alt="Tumblr">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/weebly.svg'}}"
                                                 alt="Weebly">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/dnn.svg'}}"
                                                 alt="DNN">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/squarespace.svg'}}"
                                                 alt="Squarespace">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/livejournal.svg'}}"
                                                 alt="Livejournal">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/jimdo.svg'}}"
                                                 alt="Jimdo">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/hugo.svg'}}"
                                                 alt="Hugo">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="{{'img/apps/adobeexperiencemanager.svg'}}"
                                                 alt="Adobe Experience Manager">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4  hidden-xs hidden-sm karousel__card">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                        <h4 class="text-center">
                                            Ecommerce
                                        </h4>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo6.jpg"
                                                 alt="img">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 hidden-xs hidden-sm karousel__card">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                        <h4 class="text-center">
                                            Message Boards
                                        </h4>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                        <div class="karousel__logowrapper">
                                            <img class="img-responsive"
                                                 src="http://arkahost.com/wp-content/uploads/2015/07/scripts-logo8.jpg"
                                                 alt="img">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-applications" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-applications" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid chrome">
        <div class="row chrome__wrapper">
            <div class="col-md-6 p-l-0">
                <div class="pull-left chrome__demo">
                    {{--Insert image here--}}
                </div>

            </div>
            <div class="col-md-6">
                <h1>Get our Chrome extension. It's Free.</h1>
                <p>Toggle's Chrome extension lets you find the technologies behind the website you're
                    browsing in a click!</p>
                <button class="m-t-50 btn btn-success input-xlg btn-animate">
                    <i class="fa fa-chrome" aria-hidden="true"></i>
                    &nbsp;Get Chrome Extension
                </button>
            </div>


            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="separator">
                    <img class="separator__image" src="{{asset('/img/separator.svg')}}" alt="separator">
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <footer class="col-md-12 text-center footerhome">
                <small class="text-muted"> © {{ Carbon\Carbon::now()->format('Y') }} Toggle.me</small>
            </footer>
        </div>
    </div>
@endsection

