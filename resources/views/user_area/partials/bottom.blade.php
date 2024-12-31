<!-- Bottom Navigation -->
<div class="bottom-nav">
    <nav class="light-green lighten-1">
      <div class="nav-wrapper">
        <ul class="center-align row">
          <li class="col s4"><a href="{{ url('user_area')}}" class="{{ Request::is('user_area') ? 'active' : '' }}"><i class="material-icons">home</i></a></li>
          <li class="col s4"><a href="{{ url('user_area/product')}}" class="{{ Request::is('user_area/product*') ? 'active' : '' }}"><i class="material-icons">store</i></a></li>
          <li class="col s4"><a href="{{ url('user_area/profile')}}" class="{{ Request::is('user_area/profile*') ? 'active' : '' }}"><i class="material-icons">person</i></a></li>
        </ul>
      </div>
    </nav>
  </div>