<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home*') ? 'active' : '' }}">
                <a href="{{ url('/home') }}" class="nav-link">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">User management</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i><span>Data</span></a>
                <ul class="dropdown-menu">
                    <li class=''>
                        <a class="nav-link" href="{{ route('users.index') }}"><i
                                class="fa fa-address-book"></i><span>Users</span></a>
                    </li>
                </ul>
                {{-- <li class='{{ Request::is('users') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ route('users.index') }}">Users</a>
                    </li> --}}

        </ul>
    </aside>
</div>
{{-- <ul class="dropdown-menu">
    <li class='{{ Request::is('/home') ? 'active' : '' }}'>
        <a class="nav-link"
            href="{{ url('/home') }}">General Dashboard</a>
    </li>
   
</ul> --}}
