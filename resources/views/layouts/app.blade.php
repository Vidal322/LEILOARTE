<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <h1><a href="{{ url('/') }}">LeiloArte</a></h1>
        
        <li><nav class="navigation"><input type="text" placeholder="Search.."></nav></li>
        <li><a class = "button" href="{{ route('home') }}"> Home </a></li>
        <li><a class = "button" href="{{ route('home')}}"> About us </a></li>
        @if (Auth::check())
          <li><a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span></li>
        @endif
        @if (!Auth::check())
          <li><a class="button" href="{{ url('/login') }}"> Login </a></li>
          <li><a class="button" href="{{ url('/register') }}"> Register </a></li>
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
