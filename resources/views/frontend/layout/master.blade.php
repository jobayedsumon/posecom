<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">


    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ logo($general_setting->site_logo) }}">

    <!-- CSS
    ========================= -->
    <!--bootstrap min css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/bootstrap.min.css">
    <!--owl carousel min css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/owl.carousel.min.css">
    <!--slick min css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/slick.css">
    <!--magnific popup min css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/magnific-popup.css">
    <!--font awesome css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/font.awesome.css">
    <!--ionicons css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/ionicons.min.css">
    <!--simple line icons css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/simple-line-icons.css">
    <!--animate css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/animate.css">
    <!--jquery ui min css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/jquery-ui.min.css">
    <!--slinky menu css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/slinky.menu.css">
    <!--plugins css-->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/plugins.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend')}}/css/style.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="{{ asset('frontend/css/menukit.css') }}">
    <script src="{{ asset('frontend/js/menukit.js') }}"></script>



    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    @stack('css')

<!-- Begin Inspectlet Asynchronous Code -->
{{--    <script type="text/javascript">--}}
{{--        (function() {--}}
{{--            window.__insp = window.__insp || [];--}}
{{--            __insp.push(['wid', 311419059]);--}}
{{--            var ldinsp = function(){--}}
{{--                if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=311419059&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };--}}
{{--            setTimeout(ldinsp, 0);--}}
{{--        })();--}}
{{--    </script>--}}
    <!-- End Inspectlet Asynchronous Code -->

    <!-- Load Facebook SDK for JavaScript -->
{{--    <div id="fb-root"></div>--}}
{{--    <script>--}}
{{--        window.fbAsyncInit = function() {--}}
{{--            FB.init({--}}
{{--                xfbml            : true,--}}
{{--                version          : 'v8.0'--}}
{{--            });--}}
{{--        };--}}

{{--        (function(d, s, id) {--}}
{{--            var js, fjs = d.getElementsByTagName(s)[0];--}}
{{--            if (d.getElementById(id)) return;--}}
{{--            js = d.createElement(s); js.id = id;--}}
{{--            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';--}}
{{--            fjs.parentNode.insertBefore(js, fjs);--}}
{{--        }(document, 'script', 'facebook-jssdk'));</script>--}}

{{--    <!-- Your Chat Plugin code -->--}}
{{--    <div class="fb-customerchat"--}}
{{--         attribution=setup_tool--}}
{{--         page_id="215715411952608"--}}
{{--         theme_color="#d696bb">--}}
{{--    </div>--}}

    <!--modernizr min js here-->
    <script src="{{ asset('frontend')}}/js/vendor/modernizr-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    @stack('scripts')


</head>

<body data-turbolinks="false">
<!--header area start-->
@yield('header')
<!--header area end-->

@yield('content')

<!--slider area start-->
@yield('slider')
<!--slider area end-->

<!--banner area start-->
@yield('banner')
<!--banner area end-->

<!--product area start-->
@yield('featured')
<!--product area end-->

<!--banner static area start-->
@yield('deals')

@yield('product-filter')
<!--banner static area end-->

<!--product area start-->
@yield('new-arrival')
<!--product area end-->

<!--testimonial area start-->
@yield('testimonial')
<!--testimonial area end-->

<!--blog area start-->

<!--blog area end-->

<!--shipping area start-->
@yield('shipping')
<!--shipping area end-->


<!-- modal area start-->
@yield('modal')
<!-- modal area end-->

@yield('script')

<!--footer area start-->
@yield('footer')
<!--footer area end-->


<script src="{{ asset('js/app.js') }}"></script>

<!-- JS
============================================ -->



<!--map js code here-->
<script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfIFbp2cRAO3dMWDxCPeTpxOeu5PHBEso&callback=initMap">
</script>
<script src="https://www.google.com/jsapi"></script>
<script src="{{ asset('frontend') }}/js/map.js"></script>


<!--jquery min js-->
<script src="{{ asset('frontend')}}/js/vendor/jquery-3.4.1.min.js"></script>
<!--popper min js-->
<script src="{{ asset('frontend')}}/js/popper.js"></script>
<!--bootstrap min js-->
<script src="{{ asset('frontend')}}/js/bootstrap.min.js"></script>
<!--owl carousel min js-->
<script src="{{ asset('frontend')}}/js/owl.carousel.min.js"></script>
<!--slick min js-->
<script src="{{ asset('frontend')}}/js/slick.min.js"></script>
<!--magnific popup min js-->
<script src="{{ asset('frontend')}}/js/jquery.magnific-popup.min.js"></script>
<!--counterup min js-->
<script src="{{ asset('frontend')}}/js/jquery.counterup.min.js"></script>
<!--jquery countdown min js-->
<script src="{{ asset('frontend')}}/js/jquery.countdown.js"></script>
<!--jquery ui min js-->
<script src="{{ asset('frontend')}}/js/jquery.ui.js"></script>
<!--jquery elevatezoom min js-->
<script src="{{ asset('frontend')}}/js/jquery.elevatezoom.js"></script>
<!--isotope packaged min js-->
<script src="{{ asset('frontend')}}/js/isotope.pkgd.min.js"></script>
<!--slinky menu js-->
<script src="{{ asset('frontend')}}/js/slinky.menu.js"></script>
<!-- Plugins JS -->
<script src="{{ asset('frontend')}}/js/plugins.js"></script>

<!-- Main JS -->
<script src="{{ asset('frontend')}}/js/main.js"></script>


<script>
    // (function (window, document) {
    //     var loader = function () {
    //         var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
    //         script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
    //         tag.parentNode.insertBefore(script, tag);
    //     };
    //
    //     window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    // })(window, document);
</script>

<script src="https://cdn.tiny.cloud/1/z9ekoznbkdy5bnxd46wf7olir5sg5bk6mq07kjjp8ocrnggq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea',
    });
</script>


<script src="{{ asset('frontend')}}/js/custom.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
{{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-176936453-1"></script>--}}
{{--<script>--}}
{{--    window.dataLayer = window.dataLayer || [];--}}
{{--    function gtag(){dataLayer.push(arguments);}--}}
{{--    gtag('js', new Date());--}}

{{--    gtag('config', 'UA-176936453-1');--}}
{{--</script>--}}

{{--<!-- Facebook Pixel Code -->--}}
{{--<script>--}}
{{--    !function(f,b,e,v,n,t,s)--}}
{{--    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?--}}
{{--        n.callMethod.apply(n,arguments):n.queue.push(arguments)};--}}
{{--        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';--}}
{{--        n.queue=[];t=b.createElement(e);t.async=!0;--}}
{{--        t.src=v;s=b.getElementsByTagName(e)[0];--}}
{{--        s.parentNode.insertBefore(t,s)}(window, document,'script',--}}
{{--        'https://connect.facebook.net/en_US/fbevents.js');--}}
{{--    fbq('init', '3190429781022320');--}}
{{--    fbq('track', 'PageView');--}}
{{--</script>--}}
{{--<noscript><img height="1" width="1" style="display:none"--}}
{{--               src="https://www.facebook.com/tr?id=3190429781022320&ev=PageView&noscript=1"--}}
{{--    /></noscript>--}}
<!-- End Facebook Pixel Code -->

</body>

</html>
