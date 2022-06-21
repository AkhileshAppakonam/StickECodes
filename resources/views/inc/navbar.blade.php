<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
  <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'StickEcodes') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link" aria-current="page" id="home">Home</a></li>
            <li class="nav-item"><a href="/public/index.php/about" class="nav-link" id="about">About</a></li>
            <li class="nav-item"><a href="/public/index.php/services" class="nav-link" id="services">Services</a></li>
            <li class="nav-item"><a href="/public/index.php/codes/lookUp" class="nav-link" id="services">Enter a Code</a></li>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="/public/index.php/dashboard">Dashboard</a>
                          <a class="dropdown-item" href="/public/index.php/securityProfilePage">Manage Security Profiles</a>
                          <a class="dropdown-item" href="/public/index.php/keys">Manage Encrypted Keys</a>

                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>