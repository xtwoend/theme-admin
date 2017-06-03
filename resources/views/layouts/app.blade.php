<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/simple-line-icons.css') }}" rel="stylesheet">
    
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="">
    <section class="vbox" id="app">

        <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow hidden-print">
            
            <div class="navbar-header bg-white {{ (Auth::guest())? 'nav' : 'nav' }}">
                <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                    <i class="icon-list"></i>
                </a>
                <a href="{{ route('home') }}" class="navbar-brand text-lt">
                    <img src="{{ config('site.logo') }}" style="display: inline;">
                    <span class="hidden-nav-xs m-l-sm">{{ config('app.name') }}</span>
                </a>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
                    <i class="icon-settings"></i>
                </a>
            </div>

            <!-- Right Side Of Navbar -->
            <div class="navbar-right">
                <ul class="nav navbar-nav m-n hidden-xs nav-user user">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown">
                                <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                                    <img src="/images/a0.png" alt="...">
                                </span>
                                {{ Auth::user()->name }} <b class="caret"></b>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </header>
        
        <section>
            <section class="hbox stretch">
                <section id="content">
                    <section class="vbox stretch" id="bjax-el">
                            @yield('content')
                    </section>
                </section>
            </section>
        </section>
        
    </section>

    <!-- Scripts -->
    <script src="{{ asset('admin/js/app.js') }}"></script>
    @yield('js')
</body>
</html>
