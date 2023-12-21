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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" >
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script>
        const pusherAppKey = "{{ env('PUSHER_APP_KEY') }}";
        const pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
      </script>
      <script type="text/javascript" src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
      <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>

  </head>
  <body>
    <div id="overlay"></div>
    @include('partials.header')

    <main>
    <section id="content">
        @yield('content')
    </section>
    </main>
    <div id="footer-wrapper">
        <footer>
            <p>&copy; 2023-{{ date('Y') }} LeiloArte. All Rights Reserved.</p>
        </footer>
    </div>

  </body>
</html>
