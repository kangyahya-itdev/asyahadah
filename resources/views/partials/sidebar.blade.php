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
    <li class="bold {{ Request::is('admin/users*') ? 'active' : '' }}">
    <a href="{{route('admin.users')}}" class="waves-effect waves-teal">
    <i class="material-icons">people</i>Users</a>
    </li>
</ul>