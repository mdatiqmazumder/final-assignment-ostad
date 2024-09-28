@extends('layout.index')

@section('title','Book')

@section('cdn')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Custom styles for flatpickr */
    .flatpickr-calendar {
        background-color: #f0f9ff; /* Light blue background */
        color: #333; /* Default text color */
    }

    .flatpickr-day {
        font-weight: bold;
        border-radius: 50%;
        transition: background-color 0.3s, color 0.3s;
    }

    .flatpickr-day:hover {
        background-color: #0284c7; /* Hover blue background */
        color: white; /* Hover white text */
    }

    .flatpickr-day.today {
        background-color: #22c55e; /* Today’s date green background */
        color: white; /* Today’s date white text */
    }

    /* Disabled dates styling */
    .flatpickr-day.flatpickr-disabled {
        background-color: #ffebee !important; /* Light red background */
        color: #c62828 !important; /* Dark red text */
        cursor: not-allowed; /* Show disabled cursor */
    }

    .flatpickr-day.flatpickr-disabled:hover {
        background-color: #ffebee !important; /* Keep same background on hover */
        color: #c62828 !important; /* Keep same text on hover */
    }

    .flatpickr-day.selected {
        background-color: #3b82f6; /* Blue background for selected date */
        color: white !important;
    }
</style>
@endsection

@section('content')
    @include('frontend.components.header')
    @include('frontend.components.car-details')
    @include('frontend.components.footer')
@endsection
