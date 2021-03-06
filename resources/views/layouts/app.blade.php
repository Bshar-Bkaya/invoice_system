<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Frontend/frontend.invoice_system') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/css/fontawesome/all.min.css')}}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
    @if(config('app.locale') == 'ar')
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrapRTL.css')}}">
    @endif

    @yield('style')
  </head>

  <body>
    <div id="app">
      {{-- Start Navbar --}}
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">
            {{ __('Frontend/frontend.invoice_system') }}
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
          </button>

          <ul class=" d-flex list-unstyled m-auto">
            <!-- Authentication Links -->
            @guest
            @if (Route::has('login'))
            <li class="nav-item text-center">
              <a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
            </li>
            @endif

            @if (Route::has('register'))
            <li class="nav-item text-center">
              <a class="nav-link" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                  {{ __('messages.Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
            @endguest
          </ul>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="btn btn-outline-primary" href="{{route('frontend_change_locale','ar')}}">??</a>
              </li>
              <li class="nav-item ml-md-1">
                <a class="btn btn-outline-secondary" href="{{route('frontend_change_locale','en')}}">E</a>
              </li>
            </ul>
          </div>

        </div>
      </nav>
      {{-- End Navbar --}}

      <main class="py-4">
        <div class="container">
          {{-- Show Alert  --}}
          @if(session('message'))
          <div class="alert alert-{{session('alert-type')}} alert-dismissible fade show" role="alert"
            id="session-alert">
            {{ session('message')}}
            <button id="close-alert" type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          {{-- End Alert  --}}

          @yield('content')
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/fontawesome/all.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script> --}}

    <script>
      setTimeout(() => {
        let closeAlert=document.getElementById('close-alert');
        if(closeAlert){
          closeAlert.click();
        }
      }, 5000);
    </script>

    @yield('script');
  </body>

</html>
