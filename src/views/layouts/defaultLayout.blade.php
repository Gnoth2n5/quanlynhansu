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
        <div class=""></div>
        {{-- header --}}
        <header>
            @include('partials.header.navbar')
        </header>
        <div class="container-fluid page-body-wrapper">
            {{-- sidebar --}}
            <aside>
                @include('partials.sidebar.sidebar')
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
