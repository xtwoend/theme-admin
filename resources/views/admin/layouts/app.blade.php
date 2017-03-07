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
    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
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

        @include('admin.layouts.header')
        <section>
            <section class="hbox stretch">
                
                {{-- aside --}}
                @if(! Auth::guest())
                    @include('admin.layouts.aside')
                @endif

                <section id="content">
                    <section class="hbox stretch">
                        <section class="vbox">
                            
                            @yield('content')
                            
                        </section>
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
