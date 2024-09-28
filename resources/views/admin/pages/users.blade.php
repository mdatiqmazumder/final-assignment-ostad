@extends('layout.index')

@section('title', 'Dashboard')

@section('cdn')
    <link rel="stylesheet" href="{{ asset('assets/lib/css/dataTables.dataTables.min.css') }}">
    <script src="{{ asset('assets/lib/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/lib/js/dataTables.min.js') }}"></script>
@endsection

@section('content')
    @include('admin.components.header')
    @include('admin.components.users')

    @include('dashboard.components.footer')
@endsection
