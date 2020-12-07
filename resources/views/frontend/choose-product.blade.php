<div class="row">

@forelse($data as $product)

<div class="single_product col-md-4 h-auto">
    <div class="product_thumb">
        <a class="primary_img" href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">
            <img src="{{ productImage($product->image) }}" alt=""></a>

{{--        <div class="label_product">--}}
{{--            <span class="label_sale">-{{ $product->discount }}%</span>--}}
{{--        </div>--}}
        <div class="action_links">
            <ul>
                <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                <li class="compare">
                    <a href="javascript:void(0)" class="compareButton" data-id="{{ $product->id }}" title="Add to Compare">
                        <i class="icon-refresh icons"></i></a></li>
                <li class="quick_button">
                    <a data-toggle="modal" data-target="#view-modal"
                       class="quickButton"
                       title="Quick View"
                       data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
                    >
                        <i class="icon-magnifier-add icons"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="product_content grid_content">
        <h4 class="product_name"><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">
                {{ $product->name }}</a></h4>
        <div class="price_box">
            <span class="current_price">BDT {{ $product->promotion_price ?? $product->price }}</span>
            @if($product->promotion_price)
                <span class="old_price">BDT {{ $product->price }}</span>
            @endif
        </div>
        <div class="add_to_cart">
            <a data-toggle="modal" data-target="#view-modal"
               class="quickButton"
               data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
            >+ Add to cart</a>
        </div>
    </div>

</div>

@empty
@endforelse

</div>


<script>

    $('.compareButton').click(function (e) {

        e.preventDefault();

        let productId = $(this).data('id');

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/compare/add',
            data: {
                _token: CSRF_TOKEN,
                productId: productId
            },
            success: function (count) {
                sweetAlter('success', 'Product added to compare');
                console.log(count);
                $('#compareCount').text(count);

            }
        });

    });

    $('.wishlistButton').click(function (e) {

        e.preventDefault();

        let productId = $(this).data('id');

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/wishlist/add',
            data: {
                _token: CSRF_TOKEN,
                productId: productId
            },
            success: function (count) {
                sweetAlter('success', 'Product added to wishlist');
                $('#wishlistCount').text(count);

            }
        });

    });


    $('.quickButton').click(function (e) {

        var url = $(this).data('url');

        $('#dynamic-content').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
            .done(function (data) {
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response
                $('#modal-loader').hide();        // hide ajax loader
            })
            .fail(function () {
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            })
    });


</script>

@section('modal')
    @include('frontend.layout.modal')
@endsection



