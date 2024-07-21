<nav
    class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')


    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
        @can('Compras')
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{ Auth::user()->unreadNotifications->count() }} Notifications</span>
                    <div class="dropdown-divider"></div>
                    @foreach (Auth::user()->unreadNotifications as $notification)
                        <a href="#" class="dropdown-item notification-item">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="notification-text">{{ $notification->data['message'] }}</span>
                            <span
                                class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    <a href="{{ route('notifications.markAllAsRead') }}" class="dropdown-item dropdown-footer">Leido</a>
                </div>
            </li>


        @endcan
        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if (Auth::user())
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
