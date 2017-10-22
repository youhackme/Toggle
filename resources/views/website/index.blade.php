@extends('website.layouts.app')

@section('title', 'Toggle')

@section('content')

    <div class="container-fluid">

        <!--  Top Navigation  -->
        <div class="row blockNavigation blockNavigation--full">
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
                            <img src="{{asset('img/toggle4.svg')}}" alt="Logo">
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
                        <form role="form">
                            <div class="input-group">
                                <input type="text" class="form-control blockSearch__input-xlg"
                                       placeholder="https://toggle.me">
                                <span class="input-group-btn">
                      <button class="btn btn-default blockSearch__btn-search blockSearch__input-xlg" type="button">SEARCH </button>
                    </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


