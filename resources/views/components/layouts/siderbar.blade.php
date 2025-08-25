<div id="left-sidebar" class="sidebar border">
    <style>
        .user-account .dropdown .dropdown-menu {
            transform: none !important;
            border: none;
            box-shadow: 2px 0px 5px 0px rgba(0, 0, 0, 0.2);
            padding: 15px;
            background: #fff;
            border-radius: .55rem;
        }

        .sidebar-nav .metismenu a {
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -ms-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
            position: relative;
            padding: 1px 7px;
            outline-width: 0;
            color: #17191c;
            font-size: 15px;
        }

        .sidebar-nav .metismenu ul a::before {
            content: '--';
            position: absolute;
            left: 1px;
            display: none;
        }

        .sidebar-nav .metismenu ul a {
            padding: 10px 9px 1px 30px;
            position: relative;
            color: #777;
            font-size: 14px;
        }

        .sidebar-nav .metismenu a {
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -ms-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
            position: relative;
            padding: 7px 10px;
            outline-width: 0;
            color: #17191c;
            font-size: 15px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="../assets/images/user.png" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <br>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
            <hr>
        </div>

        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">

                        <!-- Dashboard -->
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Stocks Menu with Permissions -->
                        @canany(['manage.product.category', 'manage.product.list'])
                            <li
                                class="{{ request()->routeIs('admin.product.category', 'admin.list.product', 'admin.stock.purchase') ? 'active' : '' }}">
                                <a href="#Stocks">
                                    <i class="fas fa-boxes"></i>
                                    <span>Stocks</span>
                                </a>
                                <ul>
                                    @can('manage.product.category')
                                        <li class="{{ request()->routeIs('admin.product.category') ? 'active' : '' }}">
                                            <a href="{{ route('admin.product.category') }}">
                                                <i class="fas fa-tags"></i> Product Categories
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage.product.list')
                                        <li class="{{ request()->routeIs('admin.list.product') ? 'active' : '' }}">
                                            <a href="{{ route('admin.list.product') }}">
                                                <i class="fas fa-box"></i> Products
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage.product.list')
                                        <li class="{{ request()->routeIs('admin.stock.purchase') ? 'active' : '' }}">
                                            <a href="{{ route('admin.stock.purchase') }}">
                                                <i class="fas fa-cart-plus"></i> Stock Purchase
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        <!-- Customer Info with Permissions -->
                        @can('view.customers')
                            <li class="{{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                                <a href="{{ route('admin.customers') }}">
                                    <i class="fas fa-user-friends"></i>
                                    <span>Customers</span>
                                </a>
                            </li>
                        @endcan

                        <li class="{{ request()->routeIs('admin.gallery') ? 'active' : '' }}">
                            <a href="{{ route('admin.gallery') }}">
                                <i class="fas fa-images"></i>
                                <span>Gallery</span>
                            </a>
                        </li>

                        <!-- Employee Menu with Permissions -->
                        @canany(['create.employee', 'manage.employees'])
                            <li
                                class="{{ request()->routeIs('admin.create.employee', 'admin.employee') ? 'active' : '' }}">
                                <a href="#Employee">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Employee</span>
                                </a>
                                <ul>
                                    @can('create.employee')
                                        <li class="{{ request()->routeIs('admin.create.employee') ? 'active' : '' }}">
                                            <a href="{{ route('admin.create.employee') }}">
                                                <i class="fas fa-user-plus"></i> Create Employee
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage.employees')
                                        <li class="{{ request()->routeIs('admin.employee') ? 'active' : '' }}">
                                            <a href="{{ route('admin.employee') }}">
                                                <i class="fas fa-users"></i> Manage Employees
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        <!-- HRM Roles Management -->
                        @canany(['manage.roles', 'create.roles'])
                            <li class="{{ request()->routeIs('admin.add.role', 'admin.manage.role') ? 'active' : '' }}">
                                <a href="#HRM">
                                    <i class="fas fa-user-shield"></i>
                                    <span>HRM</span>
                                </a>
                                <ul>
                                    @can('create.roles')
                                        <li class="{{ request()->routeIs('admin.add.role') ? 'active' : '' }}">
                                            <a href="{{ route('admin.add.role') }}">
                                                <i class="fas fa-user-tag"></i> Add Roles
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage.roles')
                                        <li class="{{ request()->routeIs('admin.manage.role') ? 'active' : '' }}">
                                            <a href="{{ route('admin.manage.role') }}">
                                                <i class="fas fa-user-cog"></i> Manage Roles
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        <!-- Shops Menu -->
                        <li class="{{ request()->routeIs('admin.manage.shops') ? 'active' : '' }}">
                            <a href="{{ route('admin.manage.shops') }}">
                                <i class="fas fa-store"></i>
                                <span>Shops</span>
                            </a>
                        </li>

                        <!-- Orders Menu with Permissions -->
                        @canany(['users.orders.list', 'users.orders.list.pending', 'users.orders.list.complete',
                            'users.orders.list.progress'])
                            <li class="{{ request()->routeIs('users.orders.*') ? 'active' : '' }}">
                                <a href="#Orders">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Orders</span>
                                </a>
                                <ul>
                                    @can('users.orders.list.pending')
                                        <li class="{{ request()->routeIs('users.orders.list.pending') ? 'active' : '' }}">
                                            <a href="{{ route('users.orders.list.pending') }}">
                                                <i class="fas fa-hourglass-half"></i> Pending Orders
                                            </a>
                                        </li>
                                    @endcan
                                    @can('users.orders.list.complete')
                                        <li class="{{ request()->routeIs('users.orders.list.complete') ? 'active' : '' }}">
                                            <a href="{{ route('users.orders.list.complete') }}">
                                                <i class="fas fa-check-circle"></i> Completed Orders
                                            </a>
                                        </li>
                                    @endcan
                                    @can('users.orders.list.progress')
                                        <li class="{{ request()->routeIs('users.orders.list.progress') ? 'active' : '' }}">
                                            <a href="{{ route('users.orders.list.progress') }}">
                                                <i class="fas fa-spinner"></i> Progress Orders
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        <!-- Reports Menu -->
                        <li
                            class="{{ request()->routeIs('admin.sales.reports', 'admin.sales.purchase.reports') ? 'active' : '' }}">
                            <a href="#Reports">
                                <i class="fas fa-chart-line"></i>
                                <span>Reports</span>
                            </a>
                            <ul>
                                <li class="{{ request()->routeIs('admin.sales.reports') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sales.reports') }}">
                                        <i class="fas fa-file-alt"></i> Sales Report
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.sales.purchase.reports') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sales.purchase.reports') }}">
                                        <i class="fas fa-box-open"></i> Stock Purchases
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('admin.sales.profit.reports') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sales.profit.reports') }}">
                                        <i class="fas fa-chart-pie"></i> Profit/Loss Reports
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="{{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                            <a href="{{ route('admin.setting') }}">
                                <i class="fas fa-images"></i>
                                <span>Setting</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
