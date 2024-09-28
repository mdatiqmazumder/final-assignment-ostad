@extends('layout.index')

@section('title','Login To Book Your Car')

@section('content')
    @include('frontend.components.header')
    @include('frontend.components.login')
    @include('frontend.components.home-cars')
    @include('frontend.components.footer')

@endsection
