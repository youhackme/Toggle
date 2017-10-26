@extends('website.layouts.app')

@section('title', 'Toggle')

@section('content')


    @include('website.includes.navigation', [
  'logo' => 'img/toggle4.svg',
  'homepage' => true
  ])

    <div class="container-fluid">
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
            </div>
        </div>
    </div>
@endsection


