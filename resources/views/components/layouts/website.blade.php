<!DOCTYPE html>
<html lang="en">

<!-- dustech/  13 Nov 2019 12:52:03 GMT -->
@include('components.layouts.css.stylewebsite')
@livewireStyles

<body>
    @if (Auth::check())
        @include('dummy.dummy')
    @endif
    <!-- start page-wrapper -->
    <div class="page-wrapper">

        @include('Website.Preloader')

        <!-- Start header -->
        <header id="header" class="site-header header-style-1">
            <nav class="navigation navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ route('index') }}">
                            <img width="70px" src="{{ asset('website/assets/images/logo.png') }}" alt>
                            {{-- <p>LPG</p> --}}
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navigation-holder justif">
                        <button class="close-navbar"><i class="ti-close"></i></button>
                        <ul class="nav navbar-nav" style="float: right;">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                            <li class="">
                                <a href="{{ route('shop') }}" class="dropdown-toggle" data-toggle="dropdown">Shop <span
                                        class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @php
                                        $shops = DB::table('shops')->get();
                                    @endphp

                                    @foreach ($shops as $item)
                                        <li>
                                            <a href="{{ route('single.shops.Product', ['id' => $item->id]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>
                            <li><a href="{{ route('cart') }}">Cart</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            @if (Auth::check())
                                @if (Auth::user()->role == 'customer')
                                    <li> <a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                @else
                                    <li> <a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @endif
                            @else
                                <li> <a href="{{ route('user.login') }}">Login / register</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!-- end of header -->


        {{ $slot }}


        <!-- start site-footer -->
        <footer class="site-footer">
            <div class="upper-footer">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget about-widget">
                                <div class="logo widget-title">
                                    <img width="100px" src="{{ asset('website/assets/images/logo.png') }}" alt>
                                </div>
                                <p>Mikago arm towards the viewer gregor then turned to look out the window at the dull
                                    weather</p>
                                <div class="social-icons">
                                    <ul>
                                        <li><a href="#"><i class="ti-facebook"></i></a></li>
                                        <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                        <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                        <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                        <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget link-widget">
                                <div class="widget-title">
                                    <h3>Usefull Links</h3>
                                </div>
                                <ul>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">Our services</a></li>
                                    <li><a href="#">Contact us</a></li>
                                    <li><a href="#">Meet team</a></li>
                                </ul>
                                <ul>
                                    <li><a href="#">Provacu Policy</a></li>
                                    <li><a href="#">Testimonials</a></li>
                                    <li><a href="#">News</a></li>
                                    <li><a href="#">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget contact-widget service-link-widget">
                                <div class="widget-title">
                                    <h3>Our Address</h3>
                                </div>
                                <ul>
                                    <li>25/19 Duel aveniew, new Booston town, Ghana</li>
                                    <li><span>Phone:</span> 84667441</li>
                                    <li><span>Email:</span> demo@example.com</li>
                                    <li><span>Office Time:</span> 10AM- 5PM</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget newsletter-widget">
                                <div class="widget-title">
                                    <h3>Newsletter</h3>
                                </div>
                                <p>You will be notified when somthing new will be appear.</p>
                                <form>
                                    <div class="input-1">
                                        <input type="email" class="form-control" placeholder="Email Address *"
                                            required>
                                    </div>
                                    <div class="submit clearfix">
                                        <button type="submit"><i class="ti-email"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end container -->
            </div>
            <div class="lower-footer">
                <div class="container">
                    <div class="row">
                        <div class="separator"></div>
                        <div class="col col-xs-12">
                            <p class="copyright"><a href="templateshub.net">Templates Hub</a></p>
                            <div class="extra-link">
                                <ul>
                                    <li><a href="#">Privace & Policy</a></li>
                                    <li><a href="#">Terms</a></li>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end site-footer -->


    </div>
    @livewireScripts



    <!-- end of page-wrapper -->
    @include('components.layouts.js.scriptwebsite')
</body>

<!-- dustech/  13 Nov 2019 12:54:40 GMT -->

</html>
