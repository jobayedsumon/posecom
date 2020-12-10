

function sweetAlter(icon, title) {
    Swal.fire({
        backdrop: false,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 1500
    });
}

$('.wishlistButton').click(function (e) {

    e.preventDefault();

    console.log($('#wishlistCount'));

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
            console.log(count);
            sweetAlter('success', 'Product added to wishlist');
            $('.wishlistCount').text(count);

        }
    });

});

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
            $('.compareCount').text(count);

        }
    });

});


$('#addToCart').click(function (e) {

    if ($("input[name='color']").length != 0 && !$("input[name='color']").is(':checked')) {
        return alert('Please select color');
    }

    if ($("input[name='size']").length != 0 && !$("input[name='size']").is(':checked')) {
        return alert('Please select size');
    }

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    productId = $('#productId').val();
    colorId = $("input[name='color']:checked").val();
    sizeId = $("input[name='size']:checked").val();
    count = $('#count').val();

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
            console.log(data);
            sweetAlter('success', 'Product added to cart');
            $('.cart_sub_total').text('BDT ' + data.cart_sub_total);
            let cart_total_amount = parseInt(data.cart_sub_total);
            $('.cart_total_amount').text('BDT ' + cart_total_amount);
            $('.cart_items_quantity').text(data.cart_items_quantity);
        }
    });

});


$(".chooseColor").click(function () {
    $(this).addClass("activeOption");
    $(".chooseColor").not(this).removeClass("activeOption");
});

$(".chooseSize").click(function () {
    $(this).addClass("activeOption");
    $(".chooseSize").not(this).removeClass("activeOption");
});


$('.quickButton').click(function (e) {

    var url = $(this).data('url');

    $('#dynamic-content').html('');
    $('#modal-loader').show();

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html'
    }).done(function (data) {
            $('#dynamic-content').html('');
            $('#dynamic-content').html(data);
            $('#modal-loader').hide();
        }).fail(function () {
            $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"/> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
});

$('#filter').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let brand = parseInt($('.brand:selected').val());
    let size = parseInt($('.size:selected').val());

    if (isNaN(brand)) brand = -1;
    if (isNaN(size)) size = -1;

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/filter-product',
        data: {
            _token: CSRF_TOKEN,
            brand_id: brand,
            size_id: size,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            console.log(result);
            $('#chooseProduct').html(result);
        }
    });

});

$('#filterShop').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let category_id = $('#category_id').val();

    let brand = parseInt($('.brand:selected').val());


    if (isNaN(brand)) brand = -1;


    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/filter-product-shop',
        data: {
            _token: CSRF_TOKEN,
            brand_id: brand,
            category_id: category_id,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            $('#chooseProduct').html(result);
        }
    });

});

$('#filterSubShop').on('click', function (e) {

    e.preventDefault();
    let amount = $('#amount').val();
    amount = amount.split(' - ');
    minAmount = parseInt(amount[0]);
    maxAmount = parseInt(amount[1]);

    let sub_category_id = $('#sub_category_id').val();

    let brand = parseInt($('.brand:selected').val());
    let size = parseInt($('.size:selected').val());

    if (isNaN(brand)) brand = -1;
    if (isNaN(size)) size = -1;

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/filter-product-subshop',
        data: {
            _token: CSRF_TOKEN,
            brand_id: brand,
            size_id: size,
            sub_category_id: sub_category_id,
            min_amount: minAmount,
            max_amount: maxAmount
        },
        success: function (result) {
            $('#chooseProduct').html(result);
        }
    });

});

$('.rating').on('click', function (e) {
    e.preventDefault();
    let star = $(this).data('value');
    $('#star').val(star);
});

$('#customerRating').on('click', function (e) {
    e.preventDefault();

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/product/rate',
        data: {
            _token: CSRF_TOKEN,
            product_id: $('#product').val(),
            comment: $('#comment').val(),
            star: $('#star').val()
        },
        success: function (result) {
            console.log(result);
            sweetAlter('success', 'Thank you for your review!');
        }
    });

});

$('input[name="location"]').on('change', function () {
    value = $(this).val();

    switch (value) {
        case 'inside_dhaka':

            shipping_cost = 80;
            loop = cart_weight;

            while (loop > 1000) {
                shipping_cost += 20
                loop -= 1000;
            }

            $('#shippingCost').text('BDT ' + shipping_cost);


            break;

        case 'outside_dhaka':

            shipping_cost = 150;
            loop = cart_weight;

            while (loop > 1000) {
                shipping_cost += 20
                loop -= 1000;
            }

            $('#shippingCost').text('BDT ' + shipping_cost);

            break;
    }

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: '/set-shipping-cost',
        data: {
            _token: CSRF_TOKEN,
            shipping_cost: shipping_cost
        },
        success: function (data) {
            console.log(data);
        }
    });

});

$('input[name="size"]').click(function () {
    let additional_price = $(this).data('add-price');
    let product_price = $('#productPrice').val();
    let new_price = parseInt(product_price) + parseInt(additional_price);
    $('#updatedPrice').text('BDT '+new_price);
});











