
<footer class="py-2 mt-2">


    <div class="container">
        <div class="row items-center mb-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <img width="120px" src="{{ asset('frontend/img/logo/logo-amarshop.com.bd.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="widgets_container widget_newsletter">
                    <div class="subscribe_form">
                        <form id="mc-form" class="mc-form footer-newsletter" >
                            <input id="mc-email" type="email" autocomplete="off" placeholder="Subscribe with your email" />
                            <button id="mc-submit"><i class="icon-arrow-right-circle icons"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p>Address:</p>
                <p class="mb-2">
                    231 Wapda Road, West Rampura (2.11 mi)
                    <br>
                    Dhaka-1219, Bangladesh
                </p>

                <p>
                    E-mail:
                    <br>
                    amarshop.bd2020@gmail.com
                    <br>
                    info@amarshop.com.bd
                    <br>

                    Call us: +880-1998916331, +880-1891962812
                </p>

                <img src="{{ asset('frontend/img/logo/payments.png') }}" class="img-fluid" alt="">
            </div>


            <div class="col-lg-6 col-md-6 col-sm-12 flex justify-between">
                <div class="footer_right">
                    <h3 class="footer_title">My Account</h3>
                    <div class="footer_menu">
                        <ul>
                            @auth('customer')

                                <li><a class="" href="{{ route('logout_customer') }}">Logout <i class=""></i></a></li>


                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                            @endauth

                            <li><a href="{{ route('cart') }}">View Cart</a></li>
                            <li><a href="{{ route('my-account') }}">Order Status</a></li>

                        </ul>
                    </div>
                </div>

                <div class="footer_right">
                    <h3 class="footer_title">Customer Care</h3>
                    <div class="footer_menu">

                        <ul>
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/returns-exchange">Returns & Exchange</a></li>
                            <li><a href="contact-us">Contact Us</a></li>

                        </ul>
                    </div>
                </div>

                <div class="footer_right">

                    <h3 class="footer_title">Policies</h3>
                    <div class="footer_menu">

                        <ul>
                            <li><a href="/terms-conditions">Terms & Conditions</a></li>
                            <li><a href="#">Delivery & Return Policy</a></li>
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="copyright_area">
                    <p><a href="/disclaimer">Disclaimer</a> | &copy; 2020  <a href="/">Amar Shop</a>.  All rights reserved | Developed by <a href="http://vmsl.com.bd">VMSL</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="flex justify-end social_icons">
                    <li><a href="https://www.facebook.com/amarshop.com.bd/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UC38O8VwkZQ_fZVTTf4x1nMg"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.instagram.com/amarshop._net/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>


</footer>
