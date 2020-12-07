<header>
    <div class="main_header">
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="language_currency top_left">
                            <ul>


                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="language_currency text-right">
                            <ul>
                                @php
                                    $compare = \session()->get('compare') ?? [];
                                @endphp

                                <li><a href="{{ route('compare') }}"><i class="icon-refresh icons mr-1"></i> Compare (<span class="compareCount">{{ count($compare) }}</span>)</a></li>

                                @auth('customer')

                                <li><a href="{{ route('wishlist') }}"><i class="icon-heart mr-1"></i> Wishlist (<span class="wishlistCount">{{ auth()->guard('customer')->user()->wishlist->count() ?? ''  }}</span>)</a></li>

                                @elseguest('customer')
                                    <li><a href="{{ route('customer-login') }}"><i class="icon-heart mr-1"></i> Wishlist (0)</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="header_middle sticky-header">

            <nav class="navbar navbar-hover navbar-expand-lg navbar-soft">
                <div class="collapse navbar-collapse" id="main_nav99">
                    <ul class="navbar-nav flex flex-row items-center justify-evenly w-full">
                        <li class="nav-item">
                            <a href="{{ route('home') }}"><img width="300px" src="{{ logo($general_setting->site_logo) }}" alt=""></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> Shop </a>
                            <ul class="dropdown-menu">
                                @forelse(\App\Category::all() as $category)
                                    <li class="has-megasubmenu">
                                        <a class="dropdown-item" href="{{ route('shop', $category->slug) }}"> {{ $category->name }} </a>
{{--                                        <div class="megasubmenu dropdown-menu">--}}
{{--                                            <div class="row items-center">--}}
{{--                                                        @forelse($sub_categories = $category->sub_categories as $sub_category)--}}

{{--                                                            <div class="col-6">--}}

{{--                                                                <a class="" href="{{ route('subshop', [$category->id, $sub_category->id]) }}">--}}
{{--                                                                    <img width="100px" src="{{ asset($sub_category->image) }}" alt="">--}}

{{--                                                                </a>--}}

{{--                                                            </div>--}}
{{--                                                            <div class="col-6 flex align-center">--}}
{{--                                                                <a class="text-xl" href="{{ route('subshop', [$category->id, $sub_category->id]) }}">--}}

{{--                                                                    {{ $sub_category->name }}--}}

{{--                                                                </a>--}}
{{--                                                            </div>--}}

{{--                                                        @empty--}}
{{--                                                        @endforelse--}}

{{--                                            </div><!-- end row -->--}}
{{--                                        </div>--}}
                                    </li>
                                @empty
                                @endforelse

                            </ul>
                        </li>
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> Amar Care </a>--}}
{{--                            <ul class="dropdown-menu animate fade-up">--}}
{{--                                @forelse($categories = \App\Category::all() as $category)--}}

{{--                                <li><a class="dropdown-item" href="/amar-care/{{ $category->id }}">{{ $category->name }}</a></li>--}}

{{--                                @empty--}}
{{--                                @endforelse--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <li class="nav-item"><a class="nav-link" href="/about-us"> About Us </a></li>
                        <li class="nav-item"><a class="nav-link" href="/contact-us"> Contact Us </a></li>

                        @auth('customer')

                            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#"><i class="fa fa-user"></i></a>
                                <ul class="dropdown-menu animate fade-up">

                                    <li class=""><a class="dropdown-item" href="{{ route('my-account') }}">My Account <i class=""></i></a></li>

                                    <li class=""><a class="dropdown-item" href="{{ route('logout_customer') }}">Logout <i class=""></i></a></li>
                                </ul>
                            </li>


                        @elseguest('customer')
                            <li class="nav-link"><a class="nav-link" href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                        @endauth

                        <div class="col-md-2 col-lg-2 col-sm-2 flex justify-center">
                            <div class="header_account_area">
                                <div class="header_account_list search_list">
                                    <a href="javascript:void(0)"><i id="searchIcon" class="icon-magnifier icons"></i></a>
                                    <div class="dropdown_search">
                                        <form action="{{ route('search') }}" method="GET">
                                            <input placeholder="Search entire store here ..." type="text" name="search">
                                            <button type="submit"><i class="icon-magnifier icons"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="header_account_list  mini_cart_wrapper">
                                    <a href="javascript:void(0)"><i class="icon-bag icons"></i>
                                        <span class="cart_itemtotal cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>
                                        <span class="item_count cart_items_quantity">{{ session()->get('cart_items_quantity') ?? 0 }}</span>
                                    </a>
                                    <!--mini cart-->
                                    <div class="mini_cart">
                                        <div class="mini_cart_table">
                                            <div class="cart_table_border">
                                                <div class="cart_total">
                                                    <span>Sub Total:</span>
                                                    <span class="price cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>
                                                </div>
                                                <div class="cart_total mt-10">
                                                    <span>Total:</span>
                                                    <span class="price cart_total_amount">BDT {{ session()->get('cart_sub_total') ? session()->get('cart_sub_total')  : 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mini_cart_footer">
                                            <div class="cart_button">
                                                <a class="customButton" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> View cart</a>
                                            </div>

                                        </div>
                                    </div>
                                    <!--mini cart end-->


                                </div>
                            </div>
                        </div>


                    </ul>
                </div> <!-- navbar-collapse.// -->
            </nav>






{{--                    <div class="col-lg-2 col-md-2 col-sm-2 flex justify-center" style="bottom: 1rem">--}}
{{--                        <div class="logo">--}}
{{--                            <a href="{{ route('home') }}"><img width="150px" src="{{ asset('frontend/img/logo/logo-amarshop.com.bd.png')}}" alt=""></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <div class="col-lg-8 col-md-8 col-sm-8 flex justify-center">--}}
{{--                        <div class="header_right_info menu_position">--}}
{{--                            <!--main menu start-->--}}
{{--                            <div class="main_menu">--}}
{{--                                <nav>--}}
{{--                                    <ul>--}}
{{--                                        <li><a class="active"  href="{{ route('home') }}">home<i class=""></i></a>--}}

{{--                                        </li>--}}


{{--                                        <li class="mega_items"><a href="#">shop<i class="fa fa-angle-down"></i></a>--}}
{{--                                            <div class="mega_menu">--}}
{{--                                                <ul class="mega_menu_inner">--}}

{{--                                                    @php--}}
{{--                                                        $categories = \App\Category::all();--}}
{{--                                                    @endphp--}}

{{--                                                    @forelse($categories as $category)--}}
{{--                                                        <li class="mega_items"><a href="{{ route('shop', $category->id) }}">{{ $category->name }}</a>--}}

{{--                                                            <ul>--}}


{{--                                                                @forelse($sub_categories = $category->sub_categories as $sub_category)--}}

{{--                                                                    <li><a href="{{ route('subshop', [$category->id, $sub_category->id]) }}">{{ $sub_category->name }}</a></li>--}}
{{--                                                                @empty--}}
{{--                                                                @endforelse--}}

{{--                                                            </ul>--}}

{{--                                                        </li>--}}



{{--                                                    @empty--}}
{{--                                                    @endforelse--}}

{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}


{{--                                        <li><a href="#">Amar Care<i class="fa fa-angle-down"></i></a>--}}
{{--                                            <ul class="sub_menu pages">--}}

{{--                                                @forelse($categories as $category)--}}

{{--                                                <li><a class="" href="/amar-care/{{ $category->id }}">{{ $category->name }}</a></li>--}}

{{--                                                @empty--}}
{{--                                                @endforelse--}}

{{--                                            </ul>--}}
{{--                                        </li>--}}

{{--                                        <li><a href="/about-us"> About us</a></li>--}}
{{--                                        <li><a href="/contact-us"> Contact Us</a></li>--}}


{{--                                        @auth('customer')--}}

{{--                                            <li><a href="#"><i class="fa fa-user"></i><i class="fa fa-angle-down"></i></a>--}}
{{--                                                <ul class="sub_menu pages">--}}

{{--                                                    <li><a class="" href="{{ route('my-account') }}">My Account <i class=""></i></a></li>--}}

{{--                                                    <li><a class="" href="{{ route('logout_customer') }}">Logout <i class=""></i></a></li>--}}
{{--                                                </ul>--}}
{{--                                            </li>--}}


{{--                                        @elseguest('customer')--}}
{{--                                            <li><a href="{{ route('customer-login') }}">Login <i class=""></i></a></li>--}}
{{--                                        @endauth--}}

{{--                                    </ul>--}}
{{--                                </nav>--}}
{{--                            </div>--}}
{{--                            <!--main menu end-->--}}

{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="col-md-2 col-lg-2 col-sm-2 flex justify-center">--}}
{{--                        <div class="header_account_area">--}}
{{--                            <div class="header_account_list search_list">--}}
{{--                                <a href="javascript:void(0)"><i id="searchIcon" class="icon-magnifier icons"></i></a>--}}
{{--                                <div class="dropdown_search">--}}
{{--                                    <form action="{{ route('search') }}" method="GET">--}}
{{--                                        <input placeholder="Search entire store here ..." type="text" name="search">--}}
{{--                                        <button type="submit"><i class="icon-magnifier icons"></i></button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="header_account_list  mini_cart_wrapper">--}}
{{--                                <a href="javascript:void(0)"><i class="icon-bag icons"></i>--}}
{{--                                    <span class="cart_itemtotal cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>--}}
{{--                                    <span class="item_count cart_items_quantity">{{ session()->get('cart_items_quantity') ?? 0 }}</span>--}}
{{--                                </a>--}}
{{--                                <!--mini cart-->--}}
{{--                                <div class="mini_cart">--}}
{{--                                    <div class="mini_cart_table">--}}
{{--                                        <div class="cart_table_border">--}}
{{--                                            <div class="cart_total">--}}
{{--                                                <span>Sub Total:</span>--}}
{{--                                                <span class="price cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="cart_total mt-10">--}}
{{--                                                <span>Total:</span>--}}
{{--                                                <span class="price cart_total_amount">BDT {{ session()->get('cart_sub_total') ? session()->get('cart_sub_total')  : 0 }}</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="mini_cart_footer">--}}
{{--                                        <div class="cart_button">--}}
{{--                                            <a class="customButton" href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> View cart</a>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--mini cart end-->--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


        </div>
    </div>
</header>
