{{--@if($data)--}}

{{--<div class="modal fade" id="modal_box" tabindex="-1" role="dialog"  aria-hidden="true">--}}

{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}

{{--        <div class="modal-content">--}}
{{--            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                <span aria-hidden="true"><i class="ion-android-close"></i></span>--}}
{{--            </button>--}}

            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" >
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="{{ productImage($data->image) }}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="{{ productImage($data->image) }}" alt=""></a>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li >
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">
                                                <img src="{{ productImage($data->image) }}" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">
                                                <img src="{{ productImage($data->image) }}" alt=""></a>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>{{ $data->name }}</h2>
                                </div>
                                <div class="modal_price mb-10">

                                    <span class="new_price">BDT {{ $data->promotion_price ?? $data->price }}</span>
                                    @if($data->promotion_price)
                                        <span class="old_price">BDT {{ $data->price }}</span>
                                    @endif
                                </div>
                                <div class="modal_description mb-10">
                                    {!! $data->product_details !!}
                                </div>

                                <div class="variants_selects">
                                    <div class="product_variant color">
                                        <h3>Available Options</h3>


                                        @forelse($product_variant as $name => $variant)

                                            <label>{{ $name }}: </label>
                                            <div class="size">
                                                @forelse($variant as $v)
                                                    <div class="form-check-inline">

                                                        <label class="form-check-label flex flex-col-reverse items-center">
                                                            <a>{{ ucfirst($v->pivot->item_code) }}</a>
                                                            <input type="radio" class="form-check-input mt-1 variant"
                                                                   data-item-code="{{ $v->pivot->item_code }}" name="{{ $name }}" value="{{ $v->pivot->id }}"
                                                                   data-add-price="{{ $v->pivot->additional_price }}" data-quantity="{{ $v->pivot->qty }}">

                                                        </label>
                                                    </div>
                                                @empty
                                                @endforelse


                                            </div>


                                        @empty
                                        @endforelse


                                    </div>
                                    <div class="modal_add_to_cart">
                                        <form action="">
                                            <input type="hidden" id="productId_modal" value="{{ $data->id }}" required>
                                            <input min="1" max="100" step="1" value="1" id="count_modal" type="number">

                                            @if($data->qty > 0)
                                                <a id="addToCartModal" class="customButton py-3 px-5">Add to Cart</a>
                                            @else
                                                <p class="ml-2 font-bold text-danger">Out of Stock!</p>
                                            @endif
                                        </form>
                                    </div>
{{--                                </div>--}}


                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li class="instagram"><a href="#"><i class="fa fa-instagram"></i></a></li>
                                        <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--    @endif--}}


<script>

    $('#addToCartModal').click(function (e) {

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        productId = $('#productId_modal').val();
        colorId = $("input[name='color']:checked").val();
        sizeId = $("input[name='size']:checked").val();
        count = $('#count_modal').val();

        if (colorId == null || sizeId == null) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/cart/add',
            data: {
                _token: CSRF_TOKEN,
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                count: count,
            },
            success: function (data) {
                sweetAlter('success', 'Product added to cart');
                $('.cart_sub_total').text('BDT ' + data.cart_sub_total);
                let cart_total_amount = parseInt(data.cart_sub_total);
                $('.cart_total_amount').text('BDT ' + cart_total_amount);
                $('.cart_items_quantity').text(data.cart_items_quantity);
            }
        });

    });
</script>
