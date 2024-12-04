<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    @include('partials.assets.css')
    @yield('style')
</head>

<body>
    <div class="container-scroller">
        <div id="loading">
            <div class="loader"></div>
        </div>
        {{-- header --}}
        <header>
            @include('partials.header.navbar')
        </header>
        <div class="container-fluid page-body-wrapper">
            {{-- sidebar --}}
            <aside class="left-sidebar">
                @if ($_SESSION['role'] == 'admin')
                    @include('partials.sidebar.sidebar')
                @else
                    @include('partials.sidebar.sidebarTwo')
                @endif
            </aside>
            {{-- main content --}}
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    @include('partials.assets.js')

    @yield('script')

</body>
