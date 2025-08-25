<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Customer Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #000;
            color: #fff;
            font-size: 12px;
        }

        /* Sidebar styling */
        .sidebar {
            height: 100vh;
            background-color: #000;
            border-right: 1px solid #222;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #aaa;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            font-size: 18px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #111;
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px 20px;
            min-height: 100vh;
            background-color: #000;
        }

        .card {
            background-color: #111;
            color: #fff;
            border: 1px solid #222;
        }

        /* Bottom Nav for Mobile */
        .bottom-nav {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                margin-bottom: 70px;
            }

            .bottom-nav {
                display: flex;
                justify-content: space-around;
                align-items: center;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60px;
                background-color: #000;
                border-top: 1px solid #222;
                z-index: 1000;
            }

            .bottom-nav a {
                text-align: center;
                font-size: 11px;
                color: #aaa;
                text-decoration: none;
                flex: 1;
            }

            .bottom-nav i {
                font-size: 20px;
                display: block;
                margin-bottom: 2px;
            }

            .bottom-nav a.active {
                color: #fff;
            }
        }
    </style>

    @livewireStyles
</head>

<body>
    @if (Auth::check())
        @include('dummy.dummy')
    @endif

    <!-- Sidebar -->
    <div class="sidebar d-none d-md-block">
        <ul class="nav flex-column">
            <li class="px-4 mb-3 text-white fw-bold">LOGO</li>
            <li>
                <a href="{{ route('user.dashboard') }}"
                    class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('user.orders') }}"
                    class="nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i> Orders
                </a>
            </li>
            <li>
                <a href="{{ route('user.wallet') }}"
                    class="nav-link {{ request()->routeIs('user.chat') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i> Wallet
                </a>
            </li>
            <li>
                <a href="{{ route('user.profile') }}"
                    class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
            </li>
            <li>
                <a href="{{ route('user.referal') }}"
                    class="nav-link {{ request()->routeIs('user.referal') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Referal Users
                </a>
            </li>
            <li>
                <a href="{{ route('user.notification') }}"
                    class="nav-link {{ request()->routeIs('user.notification') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i> Notifications
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('user.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn nav-link " style="background: none; border: none;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content p-2">
        <div class="d-flex align-items-center justify-content-between p-3 bg-light">
            <div>
                <h6 class="mb-0 text-muted">Customers Dashboard</h6>
                <h4 class="text-muted">Welcome Mr. {{ Auth::user()->name }}</h4>
            </div>
            <div>
                <img src="{{ Auth::user()->profile }}" alt="Profile Image" class="rounded-circle"
                    style="width: 45px; height: 45px; object-fit: cover;">
            </div>
        </div>
        <br>
        <br>
        {{ $slot }}
    </div>

    <!-- Bottom Navigation for Mobile -->j
    <div class="bottom-nav d-md-none">
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Orders
        </a>
        <a href="{{ route('user.wallet') }}" class="{{ request()->routeIs('user.chat') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> Wallet
        </a>
        <a href="{{ route('user.referal') }}" class="{{ request()->routeIs('user.referal') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Referal Users
        </a>
        <a href="{{ route('user.notification') }}"
            class="{{ request()->routeIs('user.notification') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifications
        </a>

        <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
    </div>

    @if (Auth::check())
        @livewire('website.message-icon-float')
    @endif
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts

</body>

</html>
