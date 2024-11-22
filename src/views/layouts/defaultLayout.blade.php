<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    @include('partials.assets.css')
</head>

<body>
    <div class="container-scroller">
        {{-- header --}}
        <header>
            @include('partials.header')
        </header>
        {{-- sidebar --}}
        <aside>
            @include('partials.sidebar')
        </aside>
        {{-- main content --}}
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            {{-- footer --}}
            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>

    <!-- plugins:js -->
    @include('partials.assets.js')
</body>
