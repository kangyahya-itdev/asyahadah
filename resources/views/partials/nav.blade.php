<nav class="light-green lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo" style='font-size:20px'>Asyahadah Store</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{url('/')}}">Beranda</a></li>
        <li><a href="{{url('/login')}}">Login</a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li><a href="{{url('/')}}">Beranda</a></li>
        @if(auth()->check())
           <li><a href="{{ url('/user_area/profile') }}">Profile</a></li>
           <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
              </form>
            </li>
        @else
           <li> <a href="{{ url('/login') }}">Login</a> </li>
        @endif
        
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>