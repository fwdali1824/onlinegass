<div>

    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <h2>Contact Us</h2>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

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
                        <a href="{{ route('services') }}" class="theme-btn">Our Services</a>
                        {{-- <a href="#" class="theme-btn-s3">Contact Us</a> --}}
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
</div>
