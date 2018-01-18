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

            <!--  Headlines & Search bar  -->
            <div class="hero js-hero col-md-12">
                <div class="hero__wrapper">
                    <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
                        <h2 class="hero__headline m-t-0 p-b-20">
                            Find out what
                            <span class="typed"></span>
                            your favorite sites
                            are using!
                        </h2>
                    </div>
                    <div class=" col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="blockSearch m-t-70">
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
    </div>

    <div class="container-fluid explainer">
        <div class="row text-center m-t-50">
            <h1 class="explainer__title" data-parallax='{"y": -30}'>
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
                        <!-- Slide#1-->
                        <div class="item active karousel__item">
                            <div class="col-md-4 karousel__card">
                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Content Management Systems
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
                            <div class="col-md-4  hidden-xs hidden-sm karousel__card">

                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Ecommerce platforms
                                    </h4>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/magento.svg'}}"
                                             alt="Magento">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/prestashop.svg'}}"
                                             alt="Prestashop">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/opencart.svg'}}"
                                             alt="Opencart">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/oscommerce.svg'}}"
                                             alt="OSCommerce">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/bigcommerce.svg'}}"
                                             alt="Bigcommerce">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/cscart.svg'}}"
                                             alt="CScart">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/shopify.svg'}}"
                                             alt="Shopify">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/shopware.svg'}}"
                                             alt="Shopware">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/epages.svg'}}"
                                             alt="Epages">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/xtcommerce.svg'}}"
                                             alt="Xt:commerce">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/ezpublish.svg'}}"
                                             alt="EZ Publisher">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/volusion.svg'}}"
                                             alt="Volusion">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/lightspeed.svg'}}"
                                             alt="Lightspeed">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/xcart.svg'}}"
                                             alt="Xcart">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/whmcs.svg'}}"
                                             alt="WHMCS">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 hidden-xs hidden-sm karousel__card">

                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Message Boards
                                    </h4>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/phpbb.svg'}}"
                                             alt="PHPBB">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/vbulletin.svg'}}"
                                             alt="Vbulletin">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/discourse.svg'}}"
                                             alt="Discourse">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/smf.svg'}}"
                                             alt="Simple Machine Forum">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/ipb.svg'}}"
                                             alt="Invision PowerBoard">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/mybb.svg'}}"
                                             alt="MyBB">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/vanilla.svg'}}"
                                             alt="Vanilla Forum">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/fluxbb.svg'}}"
                                             alt="Fluxbb">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/punbb.svg'}}"
                                             alt="PunBB">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/xenforo.svg'}}"
                                             alt="Xenforo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide#2-->
                        <div class="item karousel__item">
                            <div class="col-md-4 karousel__card">

                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Web Frameworks
                                    </h4>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/bootstrap.svg'}}"
                                             alt="Bootstrap">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/laravel.svg'}}"
                                             alt="Laravel">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/symfony.svg'}}"
                                             alt="Symfony">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/ember.svg'}}"
                                             alt="Ember">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/flask.svg'}}"
                                             alt="Flask">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/rails.svg'}}"
                                             alt="Rails">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/codeigniter.svg'}}"
                                             alt="Codeigniter">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/django.svg'}}"
                                             alt="Django">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/zurb.svg'}}"
                                             alt="Zurb Foundation">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/fatfreeframework.svg'}}"
                                             alt="Fat Free Framework">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/yiiframework.svg'}}"
                                             alt="Yii Framework">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4  hidden-xs hidden-sm karousel__card">

                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Javascript Frameworks
                                    </h4>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/react.svg'}}"
                                             alt="React">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/jquery.svg'}}"
                                             alt="jQuery">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/angular.svg'}}"
                                             alt="Angular">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/aurelia.svg'}}"
                                             alt="Aurelia">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/vuejs.svg'}}"
                                             alt="Vue.js">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/polymer.svg'}}"
                                             alt="Polymer">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/meteor.svg'}}"
                                             alt="Meteor">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/handlebars.svg'}}"
                                             alt="Handlebars">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/backbonejs.svg'}}"
                                             alt="Backbone.js">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/mootools.svg'}}"
                                             alt="Mootools">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/reactivex.svg'}}"
                                             alt="ReactiveX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 hidden-xs hidden-sm karousel__card">

                                <div class="col-xs-12 col-sm-12 col-md-12 karousel__title">
                                    <h4 class="text-center">
                                        Programming languages
                                    </h4>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/php.svg'}}"
                                             alt="PHP">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/nodejs.svg'}}"
                                             alt="NodeJs">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/java.svg'}}"
                                             alt="Java">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/golang.svg'}}"
                                             alt="Go Lang">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/lua.svg'}}"
                                             alt="Lua Programming language">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/scala.svg'}}"
                                             alt="Scala">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/erlang.svg'}}"
                                             alt="Erlang">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-2 col-md-4 karousel__logo">
                                    <div class="karousel__logowrapper">
                                        <img class="img-responsive"
                                             src="{{'img/apps/ruby.svg'}}"
                                             alt="Ruby">
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
            <div data-parallax='{"y": -35}' class="col-md-6  hidden-xs hidden-sm p-l-0">
                <div class="chrome__demo">
                    <img class="img-responsive" src="{{asset('/img/toggle.gif')}}" alt="Toggle Chrome extension">
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12">
                <h1 data-parallax='{"y": -25}' class="chrome__heading">Get our Chrome extension. It's Free.</h1>
                <h4 data-parallax='{"y": -35}' class="chrome__subheading">Toggle's Chrome extension lets you find the
                    technologies behind the
                    website you're
                    browsing in a click!</h4>
                <a target="_blank"
                   href="https://chrome.google.com/webstore/detail/toggle/opkmhmdcgdplgnmkcmmhilaedpehejap">
                    <button class="m-t-50 btn btn-success input-xlg btn--download">
                        <i class="fa fa-chrome" aria-hidden="true"></i>
                        &nbsp;Get Chrome Extension
                    </button>
                </a>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="separator">
                    <img class="separator__image" src="{{asset('/img/separator.svg')}}" alt="separator">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <footer class="col-md-12 text-center footerhome">
                <div class="col-md-2 col-sm-3 col-xs-3">
                    <img class="img-responsive" src="{{asset('img/logoBlackOnWhite.svg')}}" alt="Logo">
                </div>
                <div class="col-md-offset-6 col-md-4 col-sm-offset-4 col-sm-5 col-xs-offset-0 col-xs-9">
                    <div class="footerhome__list col-md-6 col-sm-6 col-xs-6">
                        <h5 class="text-left footerhome__heading">Company</h5>
                        <ul class="p-l-0">
                            <li><a href="/about">About</a></li>
                            <li><a href="/privacy">Privacy Policy</a></li>
                            <li><a href="/extension">Chrome Extension</a></li>
                        </ul>
                    </div>
                    <div class="footerhome__list col-md-6 col-sm-6 col-xs-6">
                        <h5 class="text-left footerhome__heading">Support</h5>
                        <ul class="p-l-0">
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">API</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-12">
                    <small class="text-muted text-left p-t-30"> © {{ Carbon\Carbon::now()->format('Y') }}
                        TOGGLE.ME. All Rights Reserved.
                    </small>
                </div>

            </footer>
        </div>
    </div>
@endsection

