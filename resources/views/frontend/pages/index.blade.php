@extends('layout.index')

@section('title','Home')

@section('content')
    @include('frontend.components.header')
    @include('frontend.components.hero-section')

    @include('frontend.components.home-cars')
    @include('frontend.components.about-us')
    @include('frontend.components.contact')


    @include('frontend.components.footer')

@endsection
