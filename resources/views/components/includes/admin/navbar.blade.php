<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-header">
    <a class="navbar-brand logo-header" href="#">
        <img src="{{asset('assets/images/logo.svg')}}" alt="Admin logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
            <li class="nav-item ">
                <a class="nav-link sidenav-item dasboard-link" href="{{route('admin.dashboard')}}">
                    <img src="{{asset('assets/images/admin/side-dashboard.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/dash.png')}}" class="icon-blue pr-2" width="30" height="30">
                    Dashboard<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.products') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Products</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.category') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Categories</a>
            </li>
            <!-- <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ url('sub_category') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Sub Categories</a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.attributes') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Attributes</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.catelogs') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Catalogs</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.colors') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Colors</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.blog.index') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Blogs</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.blog.category') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Blog Categories</a>
            </li>

            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.page-setting') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Page Settings</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.customers.list') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Customers</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link sidenav-item" href="{{ route('admin.orders') }}"><img
                        src="{{asset('assets/images/admin/plots.svg')}}" class="icon-white pr-2" width="30"
                        height="30">
                    <img src="{{asset('assets/images/admin/blue-plots.png')}}" class="icon-blue pr-2" width="30"
                        height="30">
                    Orders</a>
            </li>
               @php
    // Detect if any of the submenu routes are active
    $bangleActive = request()->routeIs('admin.banglez-size') ||
                    request()->routeIs('admin.box-sizes') ||
                    request()->routeIs('admin.bangle-box-colors');
@endphp

<li class="nav-item">
    <a class="nav-link sidenav-item d-flex align-items-center justify-content-between toggle-menu" 
       data-bs-toggle="collapse" 
       href="#bangleBoxMenu" 
       role="button" 
       aria-expanded="{{ $bangleActive ? 'true' : 'false' }}" 
       aria-controls="bangleBoxMenu"
       onclick="return false;">
        
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/images/admin/plots.svg') }}" class="icon-white pr-2" width="30" height="30">
            <img src="{{ asset('assets/images/admin/blue-plots.png') }}" class="icon-blue pr-2" width="30" height="30">
            Bangle Box
        </div>

        <i class="fa fa-chevron-down small rotate-icon {{ $bangleActive ? 'rotated' : '' }}"></i>
    </a>

    <ul class="collapse list-unstyled ms-4 {{ $bangleActive ? 'show' : '' }}" id="bangleBoxMenu">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.banglez-size') ? 'active' : '' }}" 
               href="{{ route('admin.banglez-size') }}">
               Bangle Sizes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.box-sizes') ? 'active' : '' }}" 
               href="{{ route('admin.box-sizes') }}">
               Box Sizes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.bangle-box-colors') ? 'active' : '' }}" 
               href="{{ route('admin.bangle-box-colors') }}">
               Bangle Box Colors
            </a>
        </li>
    </ul>
</li>




        </ul>
        <form class="form-inline  mt-2 mt-md-0 ml-auto navbar-header-right-section pt-2 pt-lg-0">

            <div class="form-group has-search profile mr-4">
                <!-- <img src="{{asset('assets/images/admin/profile.svg')}}" class="mr-2"> -->
                <span>Admin</span>
            </div>
            <div class="form-group has-search">
                <div class="dropdown dropdown-logout">
                    <img src="{{asset('assets/images/admin/arrow-down.svg')}}" class="dropdown-toggle"
                        id="dropdownMenuButton" data-toggle="dropdown">
                    <div class="dropdown-menu text-center logout-dropdown" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item logout" href="{{ route('logout') }}"><i class="fa fa-sign-out pr-2"
                                aria-hidden="true"></i>Logout</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
</nav>