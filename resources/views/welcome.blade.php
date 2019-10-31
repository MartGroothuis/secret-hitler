@extends('layouts.app')

@section('content')

<div class="red-background">
<div class="container" style="height: 100vh;">

    <div class="d-flex justify-content-center">
        <img class="w-100" src="{{asset('images/banner-new.png')}}" alt="banner">
    </div>

    <div class="d-flex justify-content-center ">
        <div class="col-12 col-sm-10 col-md-8 d-flex justify-content-between align-items-center">
            <!-- <img class="d-none d-sm-block" src="{{asset('images/fascist-logo.png')}}" alt="fascist" style="width: 20%; "> -->

            @if(Auth::guest())
            <div class="btn justify-content-center w-100">
                <a style="min-width: 100px" href="{{ route('login') }}" class="btn btn-lg btn-outline-light w-50">{{ __('login') }}</a>
            </div>
            <div class="btn justify-content-center w-100">
                <a style="min-width: 100px" href="{{ route('register') }}" class="btn btn-lg btn-outline-light w-50">{{ __('Register') }}</a>
            </div>
            @else
            <div class="btn justify-content-center w-50">
                <a href="/lobby" class="btn btn-lg btn-outline-light w-50">Go to Lobby</a>
            </div>
            @endif

            <!-- <img class="d-none d-sm-block" src="{{asset('images/liberal-logo.png')}}" alt="liberaal" style="width: 20% "> -->
        </div>
    </div>

    <div class="fixed-bottom text-center">
        <h5 class="text-white">Powerd by: Mart, Dylan, Mylan<i class="far fa-copyright"></i></h5>
    </div>

</div>
</div>

@endsection