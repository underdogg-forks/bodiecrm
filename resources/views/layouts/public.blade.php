<!doctype html>
<html class = "no-js" lang = "">
<head>
    <meta charset = "utf-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">

    <title>
        @section('title')
        Test CRM Site
        @show
    </title>

    <!-- Update favicon -->
    <link rel = "icon" type = "image/png" href = "">

    <!-- Update page description -->
    <meta name = "description" content = "">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name = "robots" content = "noindex, nofollow">

    <link href = 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel = 'stylesheet' type = 'text/css'>

    <link rel = "stylesheet" href = "{{ asset('css/vendor.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/app.css') }}">

    <link href = "//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel = "stylesheet">

    <!--[if lt IE 9]>
        <script src = "//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
    <![endif]-->
</head>

<body class = "public">

    <header class = "bg-black">
        <div class = "wrapper row">
            <div class = "large-4 columns">
                <h3><a href = "/campaigns">Home</a></h3>
            </div>

            @if ( Auth::check() )
                <div id = "links" class = "large-8 columns text-right">
                    <h5 class = "inline"><a href = "{{ url('auth/logout') }}">Logout</a></h5>
                </div>
            @else
                <div id = "links" class = "large-8 columns text-right">
                    <h5 class = "inline"><a href = "{{ url('auth/login') }}">Login</a></h5> / 
                    <h5 class = "inline"><a href = "{{ url('auth/register') }}">Register</a></h5>
                </div>
            @endif

            @yield('header')
        </div>
    </header>

    <section>
        @yield('content')
    </section>

    <footer class = "bg-black">
        <div class = "wrapper">
            @yield('footer')

            <div class = "row text-center">
                &copy; 2014, All Rights Reserved
            </div>
        </div>
    </footer>

    <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/jquery/jquery.js') }}"><\/script>')</script>

    @yield('scripts')
</body>
</html>