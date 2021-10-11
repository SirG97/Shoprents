<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body >
<div id="app">
    <div class="">
        <div id="hamburger" class="navigation-menu">
            <svg width="20px" height="20px" viewBox="0 0 69 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g stroke="none" stroke-width="1" fill-rule="evenodd">
                    <g fill-rule="nonzero" stroke="none">
                        <g>
                            <rect x="0" y="0" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="22" width="69" height="6.2072333" rx="3.10361665"></rect> <rect x="0" y="44.7927667" width="69" height="6.2072333" rx="3.10361665"></rect>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <nav class="nav nav-sidebar">
            <div class="nav_section">
                <div class="nav_section_content company">
                    <div class="nav_item prelative">
                        <a href="" class="nav_flex">
                                <span class="company-icon d-flex justify-content-center align-items-center">
                                 <i class="fas fa-shield-alt"></i>
                                </span>
                            <span class="company_text font-weight-bold">MyShopRents</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="nav_section margin-fix scroll-menu">
                <div class="nav_section_content">
                    <div class="nav_item prelative">
                        <a href="/dashboard" class="nav_link nav_flex {{request()->is('/dashboard') ? 'active': ''}}">
                               <span class="nav_link_icon">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                               </span>
                            <span class="nav_link_text">Dashboard</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/plazas" class="nav_link nav_flex {{request()->is('/plazas') ? 'active': ''}}">
                               <span class="nav_link_icon">
                                <i class="fas fa-fw fa-home"></i>
                               </span>
                            <span class="nav_link_text">Plazas</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/newplaza" class="nav_link nav_flex {{request()->is('/newplaza') ? 'active': ''}}">
                               <span class="nav_link_icon">
                                <i class="fas fa-fw fa-home"></i>
                               </span>
                            <span class="nav_link_text">New Plaza</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/shops" class="nav_link nav_flex {{request()->is('/shops') ? 'active': ''}}">
                               <span class="nav_link_icon">
                                <i class="fas fa-fw fa-home"></i>
                               </span>
                            <span class="nav_link_text">All shops</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/new" class="nav_link nav_flex {{ request()->is('/new')}}">
                                <span class="nav_link_icon">
                                 <i class="fas fa-fw fa-plus-circle"></i>
                                </span>
                            <span class="nav_link_text">Add Shop</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/shops/almostdue" class="nav_link nav_flex {{ request()->is('/shops/almostdue') ? 'active': ''}}">
                                <span class="nav_link_icon">
                                 <i class="fas fa-fw fa-user-plus"></i>
                                </span>
                            <span class="nav_link_text">Almost Due Shops</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/shops/expired" class="nav_link nav_flex {{ request()->is('/shops/expired') ? 'active': ''}}">
                                <span class="nav_link_icon">
                                 <i class="fas fa-fw fa-exclamation-triangle"></i>
                                </span>
                            <span class="nav_link_text">Expired Shops</span>
                        </a>
                    </div>
                    <div class="nav_item prelative">
                        <a href="/payments" class="nav_link nav_flex {{ request()->is('/payments') ? 'active': ''}}">
                                <span class="nav_link_icon">
                                 <i class="fas fa-fw fa-history"></i>
                                </span>
                            <span class="nav_link_text">Payment History</span>
                        </a>
                    </div>

                    <div class="nav_item prelative">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav_link nav_flex">
                             <span class="nav_link_icon">
                              <i class="fas fa-fw fa-sign-out-alt"></i>
                             </span>
                            <span class="nav_link_text">Logout</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <header class="d-flex">
        <div class="header-page-title mr-auto">
            <div class="icon-block blue-bg">
                <i class="fas fa-fw @yield('icon')"></i>
            </div>
            <span class="header-page-title-text">@yield('title')</span>
        </div>

        <div class="header-nav">
                <span class="header-nav-item">
{{--                    <img class="avatar rounded-circle img-thumbnail img-fluid" src="/" alt="profile pics">--}}
    {{--            <p class="avatar">Hi! Noble</p>--}}
                     <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav_link nav_flex">
                             <span class="nav_link_icon">
                              <i class="fas fa-fw fa-sign-out-alt"></i>
                             </span>
                            <span class="nav_link_text">Logout</span>

                        </a>
                </span>
            <div class="nav-dropdown">
                <div class="nav-dropdown-item">
                    <a href="/profile">
                        <div class="nav-dropdown-item-link">
                            Profile
                        </div>
                    </a>
                </div>
                <div class="nav-dropdown-item">
                    <a href="/settings">
                        <div class="nav-dropdown-item-link">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="nav-dropdown-item">
                    <a href="/logout">
                        <div class="nav-dropdown-item-link">
                            Logout
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main class="main" id="main">
        <div class="main_container">
            @yield('content')
        </div>
    </main>
</div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
