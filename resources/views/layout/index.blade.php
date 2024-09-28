<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    {{-- css --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">


    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('assets/lib/js/axios.min.js') }}"></script>

    @yield('cdn')
</head>

<body class="font-montserrat">

    <div class="fixed w-full h-screen bg-blue-100 bg-opacity-50 z-[200]" id="pageloadinganim">
        <p class="block absolute h-1 bg-blue-600 animate-pageloadingprogress" id="bar"></p>
    </div>
    {{-- loading bar js --}}
    <script src="{{ asset('assets/js/config.js') }}"></script>


    @yield('content')

    {{-- success and error message from session --}}
    <script>
        window.onload = function() {
            @if (session('success'))
                notify.success('{{ session('success') }}');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notify.error("{{ $error }}");
                @endforeach
            @endif
        };
    </script>


    {{-- toast message js --}}
    <script src="{{ asset('assets/lib/js/notyf.min.js') }}"></script>

</body>

</html>
