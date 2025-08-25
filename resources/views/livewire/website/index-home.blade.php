<div>

    {{-- <img src="{{ asset('assets/images/1.png') }}" alt=""> --}}
    <!-- start of hero -->
    <section class="hero-slider hero-style-1">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slide)
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image"
                            data-background="{{ asset('storage/' . $slide->images) }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- swipper controls -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>


    <!-- start about-us-section -->
    <section class="about-us-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-md-6">
                    <div class="section-title">
                        <span>{{ $about->title ?? 'About Us' }}</span>
                        <h2>{{ $about->heading ?? 'Default Heading' }}</h2>
                    </div>
                    <div class="details">
                        <p>
                            {{ $about->content ?? 'Default content about your business.' }}
                        </p>
                    </div>

                    @if (!empty($about->points))
                        @php
                            $points = explode(',', $about->points);
                        @endphp
                        <ul class="clearfix" style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($points as $point)
                                <li style="color: #777777;"><i class="ti-check"></i> {{ trim($point) }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="col col-md-6">
                    <div class="right-col">
                        <div class="img-holder">
                            <img src="{{ asset('storage/' . $about->images) }}" alt="About Us">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @php
        $why = \App\Models\HomePage::where('section', 'why-choose')->first();
        $features = json_decode($why->points ?? '[]', true);
    @endphp

    <section class="service-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-md-6">
                    <div class="section-title-s2">
                        <h2>Product Category</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-12">
                    <div class="service-grids clearfix">
                        @foreach ($productCategory as $feature)
                            <a href="{{ route('category.product', ['id' => $feature->id]) }}">
                                <div class="grid">
                                    <img src="{{ $feature['image'] }}" alt="">
                                    <h4>{{ $feature['name'] }}</h4>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($why)
        <section class="service-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="section-title-s2">
                            <span>{{ $why->title }}</span>
                            <h2>{{ $why->heading }}</h2>
                            <p>{{ $why->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="service-grids clearfix">
                            @foreach ($features as $feature)
                                <div class="grid">
                                    <i class="{{ $feature['icon'] }}"></i>
                                    <h4>{{ $feature['title'] }}</h4>
                                    <p>{{ $feature['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <style>
        .section-title-s3,
        .section-title-s4 {
            text-align: left;
        }
    </style>

    @php
        $feature = \App\Models\HomePage::where('section', 'our-feature')->first();
        $features = json_decode($feature->points ?? '[]', true);
    @endphp

    @if ($feature)
        <section class="why-choose-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                        <div class="section-title-s3">
                            <span>{{ $feature->title }}</span>
                            <h2>{{ $feature->heading }}</h2>
                            <p>{{ $feature->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="why-choose-grids clearfix">
                            @foreach ($features as $featurePoint)
                                <div class="grid">
                                    <i class="{{ $featurePoint['icon'] ?? '' }}"></i>
                                    <h3>{{ $featurePoint['title'] ?? '' }}</h3>
                                    <p>{{ $featurePoint['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        /* Style for next/prev buttons */
        .swiper-button-next,
        .swiper-button-prev {
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            opacity: 0.5;
            /* semi-transparent by default */
            transition: opacity 0.3s ease;
            color: transparent;
            /* hide arrow icon initially */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Show arrow icon on hover */
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            opacity: 1;
            color: black;
            /* show icon in black on hover */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper(".gallerySwiper", {
                loop: true,
                slidesPerView: 4,
                spaceBetween: 20,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    992: {
                        slidesPerView: 3
                    }
                }
            });
        });
    </script>

    <section class="service-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-md-6">
                    <div class="section-title-s2">
                        <h2>Our Gallery</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-xs-12">
                    <!-- Swiper -->
                    <div class="swiper gallerySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($gallery as $image)
                                <div class="swiper-slide">
                                    <img src="{{ Storage::url($image->image) }}" alt="Gallery Image"
                                        class="img-fluid rounded shadow" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Swiper Controls -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start fun-fact-section -->
    @php
        $funFact = \App\Models\HomePage::where('section', 'fun-fact')->first();
        $facts = json_decode($funFact->points ?? '[]', true);
    @endphp

    @if ($facts)
        <section class="fun-fact-section" style="margin-top: 30px">
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="fun-fact-grids clearfix">
                            @foreach ($facts as $fact)
                                <div class="grid">
                                    <div class="info">
                                        <i class="{{ $fact['icon'] ?? '' }}"></i>
                                        <h3><span class="odometer"
                                                data-count="{{ $fact['count'] ?? 0 }}">00</span>{{ $fact['suffix'] ?? '' }}
                                        </h3>
                                        <p>{{ $fact['label'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- end fun-fact-section -->
    <br><br>

    <!-- start quote-section -->
    <section class="quote-section">
        <div class="content-area clearfix">
            <div class="left-col">
                <h2>Trusted LPG Solutions for Every Need</h2>
                <div class="details">
                    <p>Whether you need LPG for home, restaurant, or industrial use — we provide efficient, safe, and
                        affordable gas delivery and installation services. Our team is committed to ensuring quality,
                        reliability, and customer satisfaction every step of the way.</p>
                    <div class="clearfix">
                        <ul>
                            <li><i class="ti-check"></i> Fast & reliable cylinder delivery</li>
                            <li><i class="ti-check"></i> Residential, commercial & industrial service</li>
                        </ul>
                        <ul>
                            <li><i class="ti-check"></i> Certified safety standards</li>
                            <li><i class="ti-check"></i> 24/7 customer support available</li>
                        </ul>
                    </div>
                    <div class="btns">
                        <a href="#" class="theme-btn">Our Services</a>
                        <a href="#" class="theme-btn-s3">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="right-col">
                <div class="quote-area">
                    <h3>Request a Quote</h3>
                    <p>Get in touch with us today for a customized LPG solution that fits your needs.</p>
                    <form method="post" class="contact-validation-active" id="contact-quote-form">
                        <div>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Name*">
                        </div>
                        <div>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Email*">
                        </div>
                        <div>
                            <input type="text" class="form-control" name="phone" id="phone"
                                placeholder="Phone*">
                        </div>
                        <div>
                            <textarea class="form-control" name="note" id="note" placeholder="Tell us your requirements..."></textarea>
                        </div>
                        <div class="submit-area">
                            <button type="submit" class="theme-btn">Get a Quote</button>
                            <div id="loader">
                                <i class="ti-reload"></i>
                            </div>
                        </div>
                        <div class="clearfix error-handling-messages">
                            <div id="success">Thank you! We will contact you shortly.</div>
                            <div id="error">Error occurred while sending your request. Please try again later.
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end quote-section -->

    <!-- start cta-section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6 col-md-6">
                    <div class="cta-text">
                        <h3>Lets Get in Touch!</h3>
                        <p>Need a reliable LPG supplier? We're here to help with residential, commercial, and industrial
                            gas solutions. Reach out today for quick assistance and expert service.</p>
                    </div>
                </div>
                <div class="col col-lg-5 col-lg-offset-1 col-md-6">
                    <div class="contact-info">
                        <div>
                            <i class="fi flaticon-call"></i>
                            <h4>Call us</h4>
                            <p>+654894754</p>
                        </div>
                        <div>
                            <i class="fi flaticon-contact"></i>
                            <h4>Email us</h4>
                            <p>demo@example.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end cta-section -->
</div>
