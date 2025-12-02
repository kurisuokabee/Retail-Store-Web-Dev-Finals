<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Retail Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- load footer.css if present so the component styles are applied globally --}}
    @php
        $publicFooter = public_path('css/footer.css');
        $resourceFooter = resource_path('css/footer.css');
    @endphp

    @if (file_exists($publicFooter))
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/footer.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceFooter))
        <style>{!! Illuminate\Support\Facades\File::get($resourceFooter) !!}</style>
    @endif
</head>
<body class="@yield('body-class')">

    @yield('content')

    {{-- include global footer component --}}
    @include('components.footer')

</body>
</html>
