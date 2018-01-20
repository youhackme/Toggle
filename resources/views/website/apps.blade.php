@extends('website.layouts.app')

@section('title','List of Applications')

@section('content')


    @include('website.includes.navigation', [
   'logo' => 'img/logoBlackOnWhite.svg',
   'homepage' => false
   ])

    <div class="container">


        <div class="row m-t-100">

            @foreach ($apps as  $categoryName =>$applications)
                @foreach ($applications as  $name =>$application)
                    <div class="col-md-3 col-sm-6 col-xs-12 blockTechnologies__technology">
                        <div class="col-md-4 col-sm-3 col-xs-4 blockTechnologies__outericon">
                            <a href="{{$application->website}}" target="_blank">
                                <img src="storage/icons/{{$application->icon??''}}"
                                     class="img-responsive blockTechnologies__innericon"
                                     alt="{{ucfirst($name)}}">
                            </a>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-8">
                            <div class="blockTechnologies__technology-information">
                                <a href="{{$application->website}}" target="_blank">
                                    <h5> {{ucfirst($name)}}</h5>
                                </a>
                                <h5>{{$categoryName}}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>
    </div>


    <footer class="footer">
        <div class="container">
            <small class="text-muted"> © {{ Carbon\Carbon::now()->format('Y') }} Toggle.me</small>
        </div>
    </footer>


@endsection


