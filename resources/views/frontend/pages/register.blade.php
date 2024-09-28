@extends('layout.index')

@section('title','Register To Book Your Car')

@section('content')
    @include('frontend.components.header')
    @include('frontend.components.register')
    @include('frontend.components.home-cars')
    @include('frontend.components.footer')
@endsection
