<div class="product_banner_static mb-95">
    <div class="container">

        <div class="section_title">
            <h2 class="">Amar Shop Deals</h2>
        </div>

        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product_banner_left">
                    <div class="product_carousel product_column1 owl-carousel">

                        @forelse($allSale as $sale)

                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('product-details', [$sale->product->category->id, $sale->product->sub_category->id, $sale->product->id]) }}">
                                            <img src="{{ asset($sale->product->image_primary)}}" alt=""></a>
                                        <a class="secondary_img" href="{{ route('product-details', [$sale->product->category->id, $sale->product->sub_category->id, $sale->product->id]) }}">
                                            <img src="{{ asset($sale->product->image_secondary)}}" alt=""></a>
                                        <div class="label_product">
                                            <span class="label_sale">-{{ $sale->percentage }}%</span>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                               o<li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $sale->product->id }}"
                                                                        title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                                <li class="compare">
                                                    <a href="javascript:void(0)" class="compareButton" data-id="{{ $sale->product->id }}" title="Add to Compare">
                                                        <i class="icon-refresh icons"></i></a></li>
                                                <li class="quick_button">
                                                    <a data-toggle="modal" data-target="#view-modal"
                                                       class="quickButton"
                                                       title="Quick View"
                                                       data-url="{{ route('dynamicModal',['id'=>$sale->product->id])}}"
                                                    >
                                                        <i class="icon-magnifier-add icons"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <div class="product_content_inner">
                                            <h4 class="product_name"><a href="{{ route('product-details', [$sale->product->category->id, $sale->product->sub_category->id, $sale->product->id]) }}">
                                                    {{ $sale->product->name }}</a></h4>
                                            <div class="price_box">
                                                <span class="current_price">BDT {!! $sale->product->price - ($sale->product->price * $sale->percentage / 100) !!}</span>
                                                @if(!$sale->percentage == 0)
                                                    <span class="old_price">BDT {{ $sale->product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="add_to_cart">
                                                <a data-toggle="modal" data-target="#view-modal"
                                                   class="quickButton"
                                                   data-url="{{ route('dynamicModal',['id'=>$sale->product->id])}}"
                                                >+ Add to cart</a>
                                            </div>
                                        </div>
                                        <div class="product_timing">
                                            <div data-countdown="{{ date('Y-m-d', strtotime($sale->expire))  }}"></div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>

                        @empty
                        @endforelse


                    </div>

                </div>
            </div>

            <div class="col-md-8 col-lg-8 col-sm-6">
                <section class="slider_section">
                    <div class="slider_area owl-carousel stop owl-theme">

                        @forelse(\App\Deal::all() as $deal)

                            <div class="single_slider d-flex align-items-center w-full" style="background-image: url('{{ asset($deal->product->image_primary)}}')">
                                <div class="m-5 font-bold text-xl text-danger">
                                    <a class="hover:text-pink-500"
                                       href="{{ route('product-details', [$deal->product->category_id, $deal->product->sub_category_id, $deal->product->id]) }}">
                                        <i class="fa fa-gift"> </i> Take the Deal</a>
                                    <h1>at BDT {{ $deal->price }} only !</h1>
                                </div>

                            </div>

                        @empty
                        @endforelse




                    </div>
                </section>
            </div>











        </div>
    </div>
</div>
