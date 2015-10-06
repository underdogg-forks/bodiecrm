<!doctype html>
<html class = "no-js" lang = "">
<head>
    <meta charset = "utf-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">

    <title>
        @section('title')
            CRM
        @show
    </title>

    <link rel = "icon" type = "image/png" href = "">

    <meta name = "description" content = "">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name = "robots" content = "noindex, nofollow">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <link rel = "stylesheet" href = "{{ asset('css/vendor.css') }}">
    <link rel = "stylesheet" href = "{{ asset('css/app.css') }}">

    <link href = "//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel = "stylesheet">

    <script src = "https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!--[if lt IE 9]>
        <script src = "//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
    <![endif]-->

    <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/jquery/jquery.js') }}"><\/script>')</script>
</head>

<body class = "home">

    <div id = "home-body">

        @include('partials.top_menu')

        <div id = "content-wrapper">
            <aside id = "main-menu" class = "bg-black inline">
                @include('partials.main_menu')
            </aside>

            <section id = "home" class = "{{ str_replace('/', ' ', Request::path()) }} inline">

                @if ( session('errors') )
                    <div id = "flash-message" data-alert class = "alert-box alert text-center animated slideInDown">
                        @foreach ( $errors->all() as $error )
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                @if ( session('status') )
                    <div id = "flash-message" data-alert class = "alert-box success text-center animated slideInDown">
                        {{ session('status') }}
                    </div>
                @endif

                <div id = "main" class = "row">
                    <div id = "page-details" class = "row">

                        <div id = "page-details-copy" class = "small-6 columns text-left">
                            <div id = "dates">
                                @yield('dates')
                            </div>

                            <h3>@yield('subtitle')</h3>
                        </div>
                        
                        <div class = "small-6 columns text-right">
                            <div id = "links">
                                @yield('links')
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>

                <footer class = "bg-gray">
                    <div class = "wrapper">
                        @yield('footer')

                        <div class = "row text-center">
                            &copy; 2015, All Rights Reserved
                        </div>
                    </div>
                </footer>



                <aside id = "comments-panel" class = "small-4 columns animated hide">
                    <div id = "comments-panel-exit"><i class = "fa fa-remove"></i></div>

                    @yield('comments')

                </aside>
            </section>
        </div>
    </div>

    <script src = "{{ asset('js/vendor.min.js') }}"></script>

    <script>
        $(document).foundation({
            equalizer: {
                equalize_on_stack: true
            }
        });
    </script>

    <script src = "{{ asset('js/app.min.js') }}"></script>
    
    @stack('scripts')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-68533912-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>