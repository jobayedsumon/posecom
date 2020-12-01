<div class="product_area  mb-100 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>New Arrivals</h2>
                    <p>Add our new arrivals to your weekly lineup</p>
                </div>
            </div>
        </div>

        <div id="owl-demo-2" class="owl-carousel owl-theme product_column4 product_carousel">


            @forelse($newProducts as $newProduct)

                <article class="single_product mr-3">
                    <figure class="h-full flex flex-column justify-start">
                        <div class="product_thumb">
                            <a class="primary_img" href="{{ route('product-details', [$newProduct->category->id, $newProduct->id]) }}">
                                <img src="{{ productImage($newProduct->image) }}" alt=""></a>

{{--                            <div class="label_product">--}}
{{--                                <span class="label_sale">-{{ $newProduct->discount }}%</span>--}}
{{--                            </div>--}}
                            <div class="action_links">
                                <ul>
                                    <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $newProduct->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                    <li class="compare">
                                        <a href="javascript:void(0)" class="compareButton" data-id="{{ $newProduct->id }}" title="Add to Compare">
                                            <i class="icon-refresh icons"></i></a></li>
                                    <li class="quick_button">
                                        <a data-toggle="modal" data-target="#view-modal"
                                           class="quickButton"
                                           title="Quick View"
                                           data-url="{{ route('dynamicModal',['id'=>$newProduct->id])}}"
                                        >
                                            <i class="icon-magnifier-add icons"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <figcaption class="product_content">
                            <h4 class="product_name"><a href="{{ route('product-details', [$newProduct->category->id, $newProduct->id]) }}">
                                    {{ $newProduct->name }}</a></h4>
                            <div class="price_box">
                                <span class="current_price">BDT {{ $newProduct->promotion_price ?? $newProduct->price }}</span>
                                @if($newProduct->promotion_price)
                                    <span class="old_price">BDT {{ $newProduct->price }}</span>
                                @endif
                            </div>
                            <div class="add_to_cart">
                                <a data-toggle="modal" data-target="#view-modal"
                                   class="quickButton"
                                   data-url="{{ route('dynamicModal',['id'=>$newProduct->id])}}"
                                >+ Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>

            @empty
            @endforelse
        </div>

    </div>
</div>
