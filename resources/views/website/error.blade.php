@extends('website.layouts.app')

@section('title','No result found')

@section('content')


    @include('website.includes.navigation', [
   'logo' => 'img/logoBlackOnWhite.svg',
   'homepage' => false
   ])

    <div class="container" style="margin-top:200px;">
        <div class="row">
            <h4 style="text-align: center;">{{$response['error']}}</h4>
        </div>
    </div>
@endsection
