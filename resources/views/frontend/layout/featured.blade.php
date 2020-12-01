<div class="product_area  mb-95">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title">
                        <h2>Featured Products</h2>
                    </div>

                    <div class="product_tab_btn">
                        <ul class="nav nav-tabs" id="navContent">
                            @forelse($featuredCategories as $featuredCategory)
                                <li>
                                    <a class="text-uppercase" data-toggle="tab" href="#tab{{ $featuredCategory->id }}">
                                        {{ $featuredCategory->name }}
                                    </a>
                                </li>
                            @empty
                            @endforelse


                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="product_container">
            <div class="tab-content" id="tabContent">


                @forelse($featuredCategories as $featuredCategory)

                    <div class="tab-pane fade in" id="tab{{ $featuredCategory->id }}">
                        <div class="row">

                            <div class="product_carousel product_column4 owl-carousel">

                    @forelse($featuredCategory->products()->whereIn('id', $featuredProdIds)->get() as $featuredProduct)

                                    <div class="product_items">
                                        <article class=" single_product m-2">
                                            <figure class="h-full flex flex-column justify-start">
                                                <div class="product_thumb">
                                                    <a class="primary_img" href="{{ route('product-details', [$featuredProduct->category->id, $featuredProduct->id]) }}">
                                                        <img src="{{ productImage($featuredProduct->image) }}" alt=""></a>

{{--                                                    <div class="label_product">--}}
{{--                                                        <span class="label_sale">-{{ $featuredProduct->discount }}%</span>--}}
{{--                                                    </div>--}}
                                                    <div class="action_links">
                                                        <ul>
                                                            <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $featuredProduct->id }}"
                                                                                    title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                                            <li class="compare">
                                                                <a href="javascript:void(0)" class="compareButton" data-id="{{ $featuredProduct->id }}" title="Add to Compare">
                                                                    <i class="icon-refresh icons"></i></a></li>
                                                            <li class="quick_button">
                                                                <a data-toggle="modal" data-target="#view-modal"
                                                                   class="quickButton"
                                                                   title="Quick View"
                                                                   data-url="{{ route('dynamicModal',['id'=>$featuredProduct->id])}}"
                                                                >
                                                                    <i class="icon-magnifier-add icons"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <h4 class="product_name"><a href="{{ route('product-details', [$featuredProduct->category->id, $featuredProduct->id]) }}">
                                                            {{ $featuredProduct->name }}</a></h4>
                                                    <div class="price_box">
                                                        <span class="current_price">BDT {{ $featuredProduct->promotion_price ?? $featuredProduct->price }}</span>
                                                        @if($featuredProduct->promotion_price)
                                                            <span class="old_price">BDT {{ $featuredProduct->price }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="add_to_cart">
                                                        <a data-toggle="modal" data-target="#view-modal"
                                                           class="quickButton"
                                                           data-url="{{ route('dynamicModal',['id'=>$featuredProduct->id])}}"
                                                        >+ Add to cart</a>
                                                    </div>
                                                </figcaption>
                                            </figure>
                                        </article>

                                    </div>

                    @empty
                    @endforelse

                            </div>

                        </div>
                    </div>



                @empty
                @endforelse




            </div>

        </div>






    </div>
</div>

<script>

    $('#navContent li a:first').addClass('active');
    $('#tabContent div:first').addClass('active');

</script>

