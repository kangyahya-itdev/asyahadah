<ul id="nav-mobile" class="sidenav sidenav-fixed">
    <li class="bold {{ Request::is('admin') ? 'active' : '' }}">
    <a href="{{route('admin.dashboard')}}" class="waves-effect waves-teal"><i class="material-icons">dashboard</i>Dashboard</a>
    </li>
    <li class="bold {{ Request::is('admin/product*') ? 'active' : '' }}">
        <a href="{{route('admin.product')}}" class="waves-effect waves-teal">
            <i class="material-icons">shopping_cart</i>Products
        </a>
    </li>
    <li class="bold {{ Request::is('admin/commissions*') ? 'active' : '' }}">
    <a href="{{route('admin.commissions')}}" class="waves-effect waves-teal">
    <i class="material-icons">attach_money</i>Commissions</a>
    </li>
    <li class="bold {{ Request::is('admin/orders*') ? 'active' : '' }}">
    <a href="{{route('admin.orders')}}" class="waves-effect waves-teal">
    <i class="material-icons">assignment</i>Orders</a>
    </li>
    <li class="bold {{ Request::is('admin/topups*') ? 'active' : '' }}">
        <a href="{{route('admin.topups')}}" class="waves-effect waves-teal">
        <i class="material-icons">money</i>Topups</a>
    </li>
    <li class="bold {{ Request::is('admin/users*') ? 'active' : '' }}">
    <a href="{{route('admin.users')}}" class="waves-effect waves-teal">
    <i class="material-icons">people</i>Users</a>
    </li>
    <li class="bold">    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#!" class="waves-effect waves-teal" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="material-icons">exit_to_app</i> Logout
    </a>    </li>
</ul>