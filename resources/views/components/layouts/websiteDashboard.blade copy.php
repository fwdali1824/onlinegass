<!DOCTYPE html>
<html lang="en">

@include('components.layouts.css.stylewebsite')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@livewireStyles

<body>
    <div class="page-wrapper">
        @include('Website.Preloader')

        <section class="page-title bg-light py-3">
            <div class="container">
                <h2 class="mb-0">Customer Dashboard</h2>
            </div>
        </section>


        <section class="container-fluid">
            <div class="row">
                {{-- Sidebar --}}
                <div class="col-md-3 mb-4">
                    <style>
                        .sidebar {
                            background-color: #fff;
                            border-radius: 10px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                            padding: 20px;
                            position: sticky;
                            top: 100px;
                            height: 100vh;
                        }

                        .sidebar a {
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            font-size: 1rem;
                            color: #333;
                            text-decoration: none;
                            padding: 10px 15px;
                            margin-bottom: 10px;
                            border-radius: 8px;
                            transition: background 0.3s ease;
                        }

                        .sidebar button {
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            font-size: 1rem;
                            color: #333;
                            text-decoration: none;
                            padding: 10px 15px;
                            margin-bottom: 10px;
                            border-radius: 8px;
                            transition: background 0.3s ease;
                        }

                        .sidebar a:hover,
                        .sidebar a.active {
                            background-color: #f8f9fa;
                            color: #007bff;
                        }

                        .sidebar i {
                            font-size: 1.2rem;
                        }
                    </style>

                    <div class="sidebar">
                        <a href="{{ route('user.dashboard') }}"
                            class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>

                        <a href="{{ route('user.orders') }}"
                            class="{{ request()->routeIs('user.orders') ? 'active' : '' }}">
                            <i class="bi bi-bag-check"></i> Orders
                        </a>

                        <a href="{{ route('user.wallet') }}"
                            class="{{ request()->routeIs('user.wallet') ? 'active' : '' }}">
                            <i class="bi bi-wallet2"></i> Wallet
                        </a>

                        <a href="{{ route('user.chat') }}"
                            class="{{ request()->routeIs('user.chat') ? 'active' : '' }}">
                            <i class="bi bi-wallet2"></i> Chats
                        </a>

                        <a href="{{ route('user.track.order') }}"
                            class="{{ request()->routeIs('user.track.order') ? 'active' : '' }}">
                            <i class="bi bi-wallet2"></i> Track My Order
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn" style="background: none; border: none;">
                                <i class="bi bi-wallet2"></i> Logout
                            </button>
                        </form>


                    </div>

                </div>


                {{ $slot }}

            </div>
        </section>
    </div>
    @include('components.layouts.js.scriptwebsite')

    @if (Auth::check())
        @livewire('website.message-icon-float')
    @endif
    @livewireScripts
</body>

</html>
