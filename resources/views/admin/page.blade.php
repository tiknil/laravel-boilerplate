<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>@yield('title', 'Home') | {{ env('APP_NAME') }}</title>

    <!-- Styles -->
    @stack('style')
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="{{ URL::to('/') }}" class="logo">
                <span class="logo-lg">{{ env('APP_NAME') }}</span>
                <span class="logo-mini">{{ env('APP_NAME') }}</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                    </ul>
                </div>
            </nav>
        </header>

    @include('admin.sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                    @endif
                @endforeach
                @include('flash::message')
            </div> <!-- end .flash-message -->


            @yield('body')

            
        </div>
    </div>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <script type="text/javascript" src="{{ mix('/js/libraries.js') }}"></script>

    @stack('scripts')

    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
