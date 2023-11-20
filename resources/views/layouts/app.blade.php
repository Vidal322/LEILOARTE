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
        <nav class="navigation">
          <form method="GET" action="{{ route('FTSsearch') }}">
            {{ csrf_field() }}
            <input type="text" name="search" placeholder="Search..">
            <button class= "button"> Search </button>
          </form>
          <a class = "button" href="{{ route('home') }}"> Home </a>
          <a class = "button" href="{{ route('home')}}"> About us </a>
          
          @if (Auth::check())
          <form method="POST" action="{{ route('logout') }}">
            {{ csrf_field() }}
            <button class= "button"> Logout </button>
          </form>
          <span><a href= "{{ route('user', ['id'=>Auth::user()->id]) }}">{{ Auth::user()->name }}</a></span>
          @endif
          @if (!Auth::check())
            <a class="button" href="{{ url('/login') }}"> Login </a>
            <a class="button" href="{{ url('/register') }}"> Register </a>
          @endif
        </nav>
      </header>
      <section id="content">
        @yield('content')
      </section>
      <footer>
        <p>&copy; 2023-{{ date('Y') }} LeiloArte. All Rights Reserved.</p>
      </footer>
    </main>
  </body>
</html>
