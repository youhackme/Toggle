@extends('website.layouts.app')

@section('title', 'Toggle - Identify what technologies your favorite sites are using')

@section('content')

    <div class="container-fluid  hexagonal-background">
        <div class="row blockNavigation blockNavigation--full js-navigation-block ">
            <nav class="navbar   navbar-staticw-top  ">
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

                    <div id="navbar3" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="#">How it works?</a></li>
                            <li class="active"><a href="#">About</a></li>
                            <li class="active"><a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </nav>
        </div>
        <!--  Headlines & Search bar  -->
        <div class="row">
            <div class="blockHeroWrapper">
                <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
                    <h2 class="blockHeadline">
                        Find out what
                        <span class="typed"></span>
                        your favorite sites
                        are using!
                    </h2>
                </div>
                <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="blockSearch">
                        <form method="get" action="/result">
                            <div class="input-group">
                                <input type="text"
                                       id="url"
                                       name="url"
                                       class="form-control blockSearch__input-xlg"
                                       placeholder="https://toggle.me"
                                       autofocus>
                                <span class="input-group-btn">
                      <button class="btn btn-default blockSearch__btn-search blockSearch__input-xlg"
                              type="submit">SEARCH
                      </button>
                    </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 text-center section-arrow">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid explainer">
        <div class="row text-center m-t-50">
            <h1 data-parallax='{"y": -25}'>Identify over 1000 Technologies across 20+ categories</h1>
            <p data-parallax='{"y": -35}' class="text-muted">Content Management Systems, Forums, Ecommerce, Frameworks,
                you name it!</p>
        </div>

        <div class="col-md-offset-1 col-md-10 applications">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div style="background-color:red;width:1200px;height:400px;color:white;">
                            Hello World
                        </div>
                    </div>
                    <div class="item">
                        <div style="background-color:blue;width:1200px;height:400px;color:white;">
                            Hello World
                        </div>
                    </div>
                    <div class="item">
                        <div style="background-color:green;width:1200px;height:400px;color:white;">
                            Hello World
                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid"
         style="height:200px;background:linear-gradient(to bottom, #443ec2 0%, #5951ff 100%);color:#ffffff;">
        <div class="row">
            <footer style="padding-top:150px;" class="text-center">
                <p>This is a footer.</p>
            </footer>

        </div>
    </div>
@endsection


