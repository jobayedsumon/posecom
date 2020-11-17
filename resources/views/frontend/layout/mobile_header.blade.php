<!--offcanvas menu area start-->
<div class="off_canvars_overlay">

</div>
<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="icon-menu"></i></a>
                </div>
                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>

                    <div class="language_currency bottom">
                        <ul>
                            @php
                                $compare = \session()->get('compare') ?? [];
                            @endphp

                            <li><a href="{{ route('compare') }}"><i class="icon-refresh icons mr-1"></i> Compare (<span class="compareCount">{{ count($compare) }}</span>)</a></li>

                            @auth('customer')

                                <li><a href="{{ route('wishlist') }}"><i class="icon-heart mr-1"></i> Wishlist (<span class="wishlistCount">{{ auth()->guard('customer')->user()->wishlist->count()  }}</span>)</a></li>

                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}"><i class="icon-heart mr-1"></i> Wishlist (0)</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="header_account_area">
                        <div class="header_account_list search_list">
                            <a href="javascript:void(0)"><i class="icon-magnifier icons"></i></a>
                            <div class="dropdown_search">
                                <form action="{{ route('search') }}" method="GET">
                                    <input placeholder="Search entire store here ..." type="text" name="search">
                                    <button type="submit"><i class="icon-magnifier icons"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="header_account_list  mini_cart_wrapper">
                            <a href="javascript:void(0)"><i class="icon-bag icons"></i>
                                <span class="cart_itemtext">Cart:</span>
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
                                        <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> View cart</a>
                                    </div>

                                </div>
                            </div>
                            <!--mini cart end-->
                        </div>
                    </div>

                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class=" active">
                                <a href="/">Home</a>

                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Shop</a>
                                <ul class="sub-menu">
                                    @php
                                        $categories = \App\Category::all();
                                    @endphp

                                    @forelse($categories as $category)
                                        <li class="menu-item-has-children"><a href="{{ route('shop', $category->id) }}">{{ $category->name }}</a>

                                        </li>



                                    @empty
                                    @endforelse
                                </ul>
                            </li>

{{--                            <li class="menu-item-has-children">--}}
{{--                                <a href="#">Amar Care</a>--}}
{{--                                <ul class="sub-menu">--}}
{{--                                    @forelse($categories as $category)--}}

{{--                                        <li><a class="" href="/amar-care/{{ $category->id }}">{{ $category->name }}</a></li>--}}

{{--                                    @empty--}}
{{--                                    @endforelse--}}
{{--                                </ul>--}}
{{--                            </li>--}}

                            <li><a href="/about-us"> About us</a></li>
                            <li><a href="/contact-us"> Contact Us</a></li>


                            @auth('customer')

                                <li class="menu-item-has-children">
                                    <a href="#"><i class="fa fa-user"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('my-account') }}">My Account</a></li>
                                        <li><a href="{{ route('logout_customer') }}">Log Out</a></li>

                                    </ul>
                                </li>


                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="offcanvas_footer">
                        <span><a href="mailto:amarshop.bd2020@gmail.com"><i class="fa fa-envelope-o"></i> amarshop.bd2020@gmail.com</a></span>
                        <br>
                        <span><a href="mailto:inf0@amarshop.com.bd"><i class="fa fa-envelope-o"></i> info@amarshop.com.bd</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--offcanvas menu area end-->
