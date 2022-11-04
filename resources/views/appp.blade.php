<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ url('style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?= __('Shop') ?></title>
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function () {
            function renderList(products) {
                html = [
                    '<div class="container">',
                    '<tr class=" ">',
                    '<th>Title</th>',
                    '<th>Description</th>',
                    '<th>Price</th>',
                    '<th>Image</th>',
                    '</tr>',

                ].join('');

                if (window.location.hash === '#products') {
                    html += [
                        '<th colspan="2"> Action </th>',
                        '</tr>'
                    ].join('');
                } else {
                    html += [
                        '<th> Action </th>',
                        '</tr>',
                        '</thead>'
                    ].join('');
                }

                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="/storage/images/' + product.image + '" style="width: 100px; height: 100px;" data-image="' + product.image + '"></td>',
                        '</tr>',
                        '</div>',
                    ].join('');

                    switch (window.location.hash) {
                        case '#cart':
                            html += '<td><button class="remove" data-id="' + product.id + '"> Remove from Cart</button></td>';
                            break;
                        case '#products':
                            html += '<td><button class="edit" data-id="' + product.id + '"> EDIT product</button></td>';
                            html += '<td><button class="delete" data-id="' + product.id + '"> DELETE product</button></td>';
                            break;
                        default:
                            html += '<td><button class="add" data-id="' + product.id + '"> Add to Cart</button></td>';
                            break;
                    }
                });
                return html;
            }

            function renderOrders(response) {
                html = '<div>';

                $.each(response, function (key, orders) {
                    html += [
                        '<h4>Comments: ' + orders.user_name + '</h4>',
                        '<h4>Placed: ' + orders.details + '</h4>',
                        '<h4>Total:' + orders.price + '</h4>',
                        '<a class="order-details" href="#order" data-id="' + orders.id + '">View Order</a>',
                    ].join('');
                });

                html += '</div>';
                return html;
            }

            function renderOrder(response) {
                html = '<div>';
                let order = response;
                // html += [
                //     '<h4>Customer: ' + order.id + '</h4>',
                //     '<h4>Email: ' + order.user_name + '</h4>',
                //     '<h4>Comments: ' + order.details + '</h4>',
                //     '<h4>Placed: ' + order.price + '</h4>',
                // ].join('');

                $.each(response.product, function (key, product) {
                    html += [
                        '<h4>Title: ' + product.title + '</h4>',
                        '<h4>Description: ' + product.description + '</h4>',
                        '<h4>Price: ' + product.price + '</h4>',
                        '<img src="storage/images/' + product.image + '" style="width: 100px; height: 100px;" data-image="' + product.image + '">',
                    ].join('');
                });

                html += '</div>';
                return html;
            }


            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();

                switch (window.location.hash) {
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response));
                            }
                        });
                        break;
                    case '#orders':
                        $('.orders').show();
                        $.ajax('/orders', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                $('.orders .list').html(renderOrders(response));
                            }
                        });
                        break;
                    case '#order':
                        $('.order').show();
                        break;
                    case '#login':
                        $('.login').show();
                        break;

                    case '#products':
                        $.ajax('/products', {
                            type: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                $('.products').show();
                                $('.products .list').html(renderList(response));
                            }
                        });


                        break;
                    case '#product':
                        $.ajax('/product/create', {
                            type: 'GET',
                            dataType: 'json',
                            success: function () {
                                $('.product').show();
                            }
                        });
                        break;
                    default:
                        $.ajax({
                            url: '/',
                            type: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                $('.index .list').html(renderList(response));
                            }
                        });
                        $('.index').show();
                        break;
                }
            }

            // Add To Cart
            $(document).on('click', '.add', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax('/cart/store/' + id + '', {
                    type: 'POST',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#cart');
                    }
                });
            });

            //Remove From Cart
            window.onhashchange();
            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax('/cart/delete/' + id + '', {
                    type: 'DELETE',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#');
                    }
                });
            });

            ///Delete Product
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax('/products/' + id + '', {
                    type: 'DELETE',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#');
                    }
                });
            });

            //Checkout
            $(document).on('click', '.submit-order', function (e) {
                var _token = $("input[name='_token']").val();
                var name = $('#name').val();
                var details = $('#details').val();
                var comments = $('#comments').val();
                $.ajax({
                    url: '/checkout',
                    type: 'POST',
                    data: {name: name, details: details, comments: comments},
                    success: function () {
                        if ($.isEmptyObject(data.errors)) {
                            $('#customer').val('');
                            $('#email').val('');
                            $('#comments').val('');
                            $('#customer-error').hide();
                            $('#email-error').hide();
                            window.location.assign('#');
                        }
                        window.location.assign('#');
                    }
                });
            });

            //Order View
            $(document).on('click', '.order-details', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax('/order/' + id + '', {
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        window.location.assign('#order');
                        $('.order .list').html(renderOrder(response));
                    }
                });
            });

            //Edit Product
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax('/products/edit/' + id + '', {
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        $('.product-create').hide();
                        $('.product-update').show();
                        $('#product-id').val(response.id);
                        $('#title').val(response.title);
                        $('#description').val(response.description);
                        $('#price').val(response.price);
                        $('#image').text(response.image);
                        $('#title-error').hide();
                        $('#description-error').hide();
                        $('#price-error').hide();
                        $('#image-error').hide();
                        window.location.assign('#product');
                    }
                });
            });

            //
            $(document).on('click', '.add-product', function (e) {
                e.preventDefault();
                $('.product-create').show();
                $('.product-update').hide();
                $('#product-id').val(33);
                $('#title').val('ssssss');
                $('#description').val('');
                $('#price').val('');
                $('#image').text('');
                console.log( $('#product-id').val());
                window.location.assign('#product');
            });

            //Product update/ Product Add
            $('#product-form').on('submit', function (e) {
                console.log($('#product-id').val());
                if ($('#product-id') .val() != 33) {
                    e.preventDefault();
                    let id = $('input[id=product-id]').val();
                    let data = new FormData();
                    data.append('id', id);
                    data.append('title', $('input[id=title]').val());
                    data.append('description', $('input[id=description]').val());
                    data.append('price', $('input[id=price]').val());
                    console.log(data.append('title', $('input[id=title]').val()));
                    if ($('#image').get(0).files.length !== 0) {
                        data.append('image', $('#image')[0].files[0]);
                    }
                    console.log(data);
                    $.ajax({
                        url: '/products/update/' + id + '',
                        type: 'PUT',
                        data: data,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        enctype: 'multipart/form-data',
                        cache: false,
                        headers:{
                            method: "POST",

                        },
                        success: function () {
                            alert('form update was submitetd ')
                            window.location.assign('#products');
                        },
                        error: function () {
                            console.log('error');
                            window.location.assign('#products');
                        }
                    });
                } else {
                    e.preventDefault();
                    let data = new FormData();
                    data.append('title', $('input[id=title]').val());
                    data.append('description', $('input[id=description]').val());
                    data.append('price', $('input[id=price]').val());

                    console.log(data.append('title', $('input[id=title]').val()));

                    if ($('#image').get(0).files.length !== 0) {
                        data.append('image', $('#image')[0].files[0]);
                    }
                    $.ajax({
                        url: '/product/store',
                        type: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        enctype: 'multipart/form-data',
                        cache: false,
                        success: function () {
                            // $('.product-form')[0].reset();
                            alert('form was submitted');
                            window.location.assign('#products');
                        },
                        error: function () {
                            console.log('eroare');
                        }
                    });
                }
            });

        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">Go to cart</a>
    <a href="#products" class="button">Go to products</a>
    <a href="#login" class="button">Login</a>
</div>

<!-- The cart page -->
<!-- The cart element where the products list is rendered -->
<div class="page cart">
    <table class="list"></table>
    <form id="checkout-form">
        {{csrf_field()}}
        <div>
            <input id="name" name="name" placeholder="Name">

            <input id="details" name="details" placeholder="Email">
        </div>
        <div>
            <input id="comments" name="comments" placeholder="Comments">
        </div>
        <button class="submit-order" type="submit">Checkout</button>
    </form>
    <a href="#" class="button">Index</a>
    <a href="#products" class="button">Products</a>

</div>

<div class="page products">
    <table class="list"></table>
    <div>
        <a href="#product" class="add-product"> {{__('Add')}} </a>
        <a href="#cart"> {{__('cart')}} </a>
        <a href="#index"> {{__('index')}} </a>
        <a href="#orders"> {{__('Orders')}} </a>

    </div>
</div>
</div>

<div class="page product">

    <form id="product-form" enctype="multipart/form-data">
        <input type="hidden" id="product-id" value="">

        <div>
            <input type="text" id="title" placeholder=" Enter product name " value="">
            <p id="title-error"></p>
        </div>

        <div>
            <input type="text" id="description" placeholder="Enter product description" value="">
            <p id="description-error"></p>
        </div>

        <div>
            <input type="number" id="price" placeholder="Enter product price" value="">
            <p id="price-error"></p>
        </div>

        <div>
            <input type="file" id="image" value="">
            <p id="image-error"></p>
        </div>

        <button type="submit" class="product-create"> Create</button>
        <button type="submit" class="product-update"> Update</button>
    </form>

    <div>
        <a href="#products"> {{ __('Products') }} </a>
    </div>
</div>
<div class="page orders">
    <div class="list"></div>

    <div>
        <a href="#products"> {{ __('Products') }} </a>
    </div>
</div>

<div class="page order">
    <div class="list"></div>

    <div>
        <a href="#orders"> {{ __('Orders') }} </a>
    </div>
</div>

<div class="page login">
    <table class="list"></table>

    <form class="#loginForm">
        <div>
            <label>{{ __('Username') }}</label>
            <input type="text" id="username" name="username" value=""/>
            <p id="username-error"></p>

        </div>
        <div>
            <label>{{ __('Password') }}</label>
            <input type="password" id="password" name="password" value=""/>
            <p id="password-error"></p>
        </div>
        <button class="submit-login" type="submit">{{ __('Login') }}</button>
    </form>

    <a href="#">{{ __('Go to Home') }}</a>
</div>


</body>
</html>
