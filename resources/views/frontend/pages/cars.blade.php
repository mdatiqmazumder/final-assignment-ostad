@extends('layout.index')

@section('title','Home')

@section('content')
    @include('frontend.components.header')

    @include('frontend.components.all-cars')


    @include('frontend.components.footer')

@endsection
