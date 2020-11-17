@extends('frontend.layout.master')

@push('scripts')

@endpush
   <!--header area start-->
@section('header')

    @include('frontend.layout.header')

@endsection
    <!--header area end-->

@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>product details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <div class="product_details mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{ asset($product->image_primary) }}" data-zoom-image="{{ asset($product->image_secondary) }}" alt="big-1">
                            </a>
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ asset($product->image_primary) }}"
                                       data-zoom-image="{{ asset($product->image_primary) }}">
                                        <img src="{{ asset($product->image_primary) }}" alt="zo-th-1"/>
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{ asset($product->image_secondary) }}"
                                       data-zoom-image="{{ asset($product->image_secondary) }}">
                                        <img src="{{ asset($product->image_secondary) }}" alt="zo-th-1"/>
                                    </a>

                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="product_d_right">
                       <form action="#">
                            <div class="productd_title_nav">
                                <h1><a href="#">{{ $product->name }}</a></h1>
                                <input type="hidden" id="productId" value="{{ $product->id }}">
                            </div>

                           <div class=" product_ratting">
                               <ul>
                                   @for($i=0;  $i<$product->averageRate(); $i++)
                                   <li><a href="#"><i class="ion-android-star"></i></a></li>
                                   @endfor

                               </ul>
                           </div>

                           @php $discount = $product->sale ? $product->sale->percentage : $product->discount; @endphp

                            <div class="price_box">
                                <span id="currentPrice" class="current_price">BDT {{ $discount ? $product->price - round($product->price * $discount / 100) : $product->price }}</span>&nbsp;
                                @if(!$product->discount == 0)
                                <span id="oldPrice" class="old_price">BDT {{ $product->price }}</span>
                                @endif
                            </div>
                            <div class="product_desc">
                                {!! $product->short_description !!}
                            </div>
                            <div class="product_variant color">
                                <h3>Available Options</h3>
                                <label>color</label>
                                <ul>
                                    @forelse($product->colors as $color)
                                        <div class="form-check-inline">
                                            <label class="form-check-label flex flex-col-reverse items-center">
                                                <input type="radio" class="form-check-input colorId" name="color" value="{{ $color->id }}">
                                                <li class=""><a style="background-color: {{ $color->name }}"></a></li>
                                            </label>
                                        </div>

                                    @empty
                                    @endforelse

                                </ul>

                                <div class="size">
                                    <label>size</label>
                                    <ul class="">
                                        @forelse($product->sizes as $size)
                                            <div class="form-check-inline">
                                                <label class="form-check-label flex flex-col-reverse items-center">
                                                    <input type="radio" class="form-check-input sizeId" name="size" value="{{ $size->id }}">
                                                    <li class=""><a>{{ $size->name }}</a></li>
                                                </label>
                                            </div>
                                        @empty
                                        @endforelse


                                    </ul>
                                </div>

                                <div class="mt-2">
                                    <label for="">Inventory : {!! $product->quantity > 0 ? $product->quantity : 0 !!} products available</label>
                                </div>


                            </div>



                            <div class="product_variant quantity">
                                <label>quantity</label>
                                <input min="1" max="100" id="count" value="1" type="number">
                                @if($product->quantity > 0)
                                <a href="javascript:void(0)" class="customButton px-2" id="addToCart">add to cart</a>
                                @else
                                <p class="ml-2 font-bold text-danger">Out of Stock!</p>
                                @endif

                            </div>
                            <div class=" product_d_action">
                               <ul>
                                   <li><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}" title="Add to Wishlist">+ Add to Wishlist</a></li>
                                   <li><a href="javascript:void(0)" class="compareButton" data-id="{{ $product->id }}" title="Add to Compare">+ Add to Compare</a></li>

                               </ul>
                            </div>
                            <div class="product_meta">
                                <span>Category: <a href="{{ route('shop', $category->id) }}">{{ $category->name }}</a></span>
                            </div>
                           <div class="product_meta">
                               <span>Tags:
                                   @forelse($product->tags as $tag)
                                       <a href="{{ route('tag-search', $tag->name) }}">{{ $tag->name }}</a>
                                   @empty
                                   @endforelse

                               </span>
                           </div>

                        </form>
{{--                        <div class="priduct_social">--}}
{{--                            <ul>--}}
{{--                                <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>--}}
{{--                                --}}
{{--                                <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i> save</a></li>--}}
{{--                                <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i> share</a></li>--}}
{{--                                <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i> linked</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info mb-57">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li >
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                </li>
                                <li>
                                     <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{ $product->comments()->count() }})</a>
                                </li>

                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel" >
                                <div class="product_d_table">
                                   <form action="#">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="first_child">Compositions</td>
                                                    <td>{{ $product->specifications ?  $product->specifications->compositions : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Styles</td>
                                                    <td>{{ $product->specifications ?  $product->specifications->styles : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">Properties</td>
                                                    <td>{{ $product->specifications ?  $product->specifications->properties : '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="product_info_content">
                                    {!! $product->short_description !!}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel" >
                                <div class="reviews_wrapper">
                                    <h2>{{ $product->comments()->count() }} review for {{ $product->name }}</h2>

                                    @forelse($product->comments as $comment)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb">
                                                <img src="assets/img/blog/comment2.jpg" alt="">
                                            </div>
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    <div class="star_rating">
                                                        <ul>
                                                            @for($i=0; $i<$comment->rate; $i++)
                                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <p><strong>{{ $comment->commented->name }} </strong>- {{ $comment->created_at }}</p>
                                                    <span>{{ $comment->comment }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                    @endforelse


                                    @auth()

                                        <form method="POST" action="{{ route('rate-product') }}">
                                            @csrf
                                    <div class="comment_title">
                                        <h2>Add a review </h2>
                                        <p>Your email address will not be published.  Required fields are marked </p>
                                    </div>
                                    <div class="product_ratting mb-10">
                                        <h3>Your rating</h3>

                                        <ul>
                                            <input type="radio" name="star" value="5">
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="4">
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="3">
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="2">
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="1">
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                    </div>

                                            <input type="hidden" id="productId" name="product_id" value="{{ $product->id }}">

                                    <div class="product_review_form">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="review_comment">Your review *</label>
                                                <textarea name="comment" id="review_comment" ></textarea>
                                            </div>

                                        </div>
                                        <button type="submit">Submit</button>

                                    </div>
                                        </form>
                                    @elseguest('customer')
                                            <h1 class="text-xl font-weight-400">Create account and complete profile to review.</h1>
                                        @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->

    <!--product area start-->
    <section class="product_area related_products mb-57">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title psec_title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>

            <div id="owl-demo-2" class="owl-carousel owl-theme product_column4 product_carousel">


                @forelse($related_products as $related_product)

                        <article class="single_product  mr-3">
                            <figure class="h-full flex flex-column justify-start">
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{ route('product-details', [$related_product->category->id, $related_product->sub_category->id, $related_product->id]) }}">
                                        <img src="{{ asset($related_product->image_primary)}}" alt=""></a>
                                    <a class="secondary_img" href="{{ route('product-details', [$related_product->category->id, $related_product->sub_category->id, $related_product->id]) }}">
                                        <img src="{{ asset($related_product->image_secondary)}}" alt=""></a>
                                    <div class="label_product">
                                        <span class="label_sale">-{{ $related_product->discount }}%</span>
                                    </div>
                                    <div class="action_links">
                                        <ul>
                                            <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $related_product->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                            <li class="compare">
                                                <a href="javascript:void(0)" class="compareButton" data-id="{{ $related_product->id }}" title="Add to Compare">
                                                    <i class="icon-refresh icons"></i></a></li>
                                            <li class="quick_button">
                                                <a data-toggle="modal" data-target="#view-modal"
                                                        class="quickButton"
                                                        data-url="{{ route('dynamicModal',['id'=>$related_product->id])}}"
                                                >
                                                    <i class="icon-magnifier-add icons"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <figcaption class="product_content">
                                    <h4 class="product_name"><a href="{{ route('product-details', [$related_product->category->id, $related_product->sub_category->id, $related_product->id]) }}">
                                            {{ $related_product->name }}</a></h4>
                                    <div class="price_box">
                                        <span class="current_price">BDT {{ $related_product->price - round($related_product->price * $related_product->discount / 100) }}</span>
                                        @if(!$product->discount == 0)
                                            <span class="old_price">BDT {{ $product->price }}</span>
                                        @endif
                                    </div>
                                    <div class="add_to_cart">
                                        <a href="{{ route('cart') }}">+ Add to cart</a>
                                    </div>
                                </figcaption>
                            </figure>
                        </article>

                @empty
                @endforelse
            </div>
        </div>
    </section>
    <!--product area end-->

    <!--brand area start-->
    @include('frontend.layout.brand')
    <!--brand area end-->

@endsection

@section('modal')

@forelse($related_products as $related_product)
    @include('frontend.layout.modal', ['data' => $related_product])
@empty
@endforelse

@endsection





@section('script')



@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection

<div id="view-modal-review" class="modal fade"
     tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: ;">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="ion-android-close"></i></span>
            </button>

            <div class="modal_body">
                <div class="container">
                    <div class="row">

                        <ul class="flex justify-center w-full">
                            <li><a class="rating" data-value="1" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="2" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="3" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="4" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="5" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                        </ul>

                        <input id="product" type="hidden" value="{{ $product->id }}">
                        <input id="star" type="hidden" value="">

                        <div class="w-full text-center">

                            <input type="text" id="comment" class="border border-pink-100 w-full p-4 mb-2">

                            <button id="customerRating" class="customButton py-2 px-4">Rate</button>
                        </div>


                    </div>

                </div>
            </div>



        </div>
    </div>
</div><!-- /.modal -->





