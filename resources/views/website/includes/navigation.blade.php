<!--  Top Navigation  -->
<div class="container-fluid">
    <div class="row blockNavigation @if($homepage)blockNavigation--full @endif ">
        <nav class="navbar  @if($homepage) navbar-static-top @else navbar-default navbar-fixed-top @endif ">
            <div class="container">
                <div class="navbar-header">
                    <button type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#navbar3">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{env('APP_URL')}}">
                        <img src="{{asset($logo)}}" alt="Logo">
                    </a>
                </div>

                @if(!$homepage)


                    <div class="col-sm-12 col-sm-offset-2 col-md-offset-1 col-md-6 blockInlineSearch hidden-sm">
                            <form method="get" class="navbar-form" action="/result">
                            <div class="input-group  col-md-12 blockInlineSearch__valign">
                                <input type="text" class="form-control" placeholder="Search another website.." name="url">
                                <div class="input-group-btn">
                                    <button class="btn btn-default blockInlineSearch__btn-search" type="submit">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                @endif
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
