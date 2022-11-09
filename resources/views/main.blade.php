<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ url('style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?= __('Shop') ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
                    '<th>{{ __('Title') }}</th>',
                    '<th>{{ __('Description') }}</th>',
                    '<th>{{ __('Price') }}</th>',
                    '<th>{{ __('Image') }}</th>',
                    '</tr>',

                ].join('');

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
                            html += '<td><button class="remove" data-id="' + product.id + '"> {{ __('Remove from cart') }}</button></td>';
                            break;
                        case '#products':
                            html += '<td><button class="edit" data-id="' + product.id + '"> {{ __('Edit product') }}</button></td>';
                            html += '<td><button class="delete" data-id="' + product.id + '"> {{ __('Delete Product') }}</button></td>';
                            break;
                        default:
                            html += '<td><button class="add" data-id="' + product.id + '"> {{ __('Add To Cart') }}</button></td>';
                            break;
                    }
                });
                return html;
            }

            function setToken(response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': response
                    }
                });
            }

            function renderOrders(response) {
                html = '<div>';

                $.each(response, function (key, orders) {
                    html += [
                        '<h4>{{ __('Comments ') }} ' + orders.user_name + '</h4>',
                        '<h4>{{ __('Details ') }}' + orders.details + '</h4>',
                        '<h4>{{ __('Total ') }}' + orders.price + '</h4>',
                        '<a class="order-details" href="#order" data-id="' + orders.id + '">View Order</a>',
                    ].join('');
                });

                html += '</div>';
                return html;
            }

            function renderOrder(response) {
                html = '<div>';
                let orders = response.orders;
                html += [
                    '<h4><strong>{{ __('Customer Id ') }}</strong> ' + orders.id + '</h4>',
                    '<h4>{{ __('User Name ') }} ' + orders.user_name + '</h4>',
                    '<h4>{{ __('Details ') }} ' + orders.details + '</h4>',
                    '<h4>{{ __('Total Price ') }} ' + orders.price + '</h4>',
                    '<br><br>',
                ].join('');

                let products = response.products;
                $.each(products, function (key, product) {
                    html += [
                        '<h4>{{ __('Title ') }}: ' + product.title + '</h4>',
                        '<h4>{{ __('Description ') }}: ' + product.description + '</h4>',
                        '<h4>{{ __('Price ') }}: ' + product.price + '</h4>',
                        '<img src="storage/images/' + product.image + '" style="width: 100px; height: 100px;" data-image="' + product.image + '">',
                    ].join('');
                });

                html += '</div>';
                return html;
            }


            window.onhashchange = function () {
                $('.page').hide();

                switch (window.location.hash) {
                    case '#cart':
                        $('#name-error').show();
                        $('#details-error').show();
                        $.ajax('/cart', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                if (Object.entries(response).length === 0) {
                                    $('.cart .list').html('<th>{{ __('Your cart is Empty!') }}</th>');
                                    $('#checkout-form').hide();
                                } else {
                                    $('#checkout-form').show();
                                    $('.cart .list').html(renderList(response));
                                }
                            }
                        });
                        $('.cart').show();
                        break;
                    case '#orders':
                        $.ajax('/orders', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                $('.orders .list').html(renderOrders(response));
                            }
                        });
                        $('.orders').show();
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
                                $('.products .list').html(renderList(response));
                            }
                        });
                        $('.products').show();

                        break;
                    case '#product':
                        $.ajax('/product/create', {
                            type: 'GET',
                            dataType: 'json',
                            success: function () {
                                if (sessionStorage.getItem("product-id") !== null) {
                                    let title = sessionStorage.getItem("title");
                                    let description = sessionStorage.getItem("description");
                                    let price = sessionStorage.getItem("price");
                                    let image = sessionStorage.getItem("image");
                                    let productId = sessionStorage.getItem("product-id");
                                    $('#title').val(title);
                                    $('#description').val(description);
                                    if ($('#image').get(0).files.length !== 0) {
                                        $('#image')[0].files[0].name.val(image);
                                    }
                                    $('#price').val(price);
                                    $('#product-id').val(productId);
                                    $('.product-create').hide();
                                    $('.product-update').show();
                                } else {
                                    $('#product-id').val('');
                                    $('.product-create').show();
                                    $('.product-update').hide();
                                }
                            }
                        });
                        $('.product').show();
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
            //login
            $(document).on('click', '.submit-login', function (e) {

                e.preventDefault();

                let username = $('#username').val();
                let password = $('#password').val();
                $.ajax('/login', {
                    type: 'POST',
                    data: {email: username, password: password},
                    success: function () {
                        $('#username').val('');
                        $('#password').val('');
                        $('#username-error').text('');
                        $('#password-error').text('');
                    },
                    error: function (xhr) {
                        var err = JSON.parse(xhr.responseText);
                        $('#username-error').text(err.errors.email);
                        $('#password-error').text(err.errors.password);
                    }
                })
                    .then(() => {
                        $.ajax('check-csrf', {
                            type: 'GET',
                            success: function (response) {
                                setToken(response);
                                window.location.assign('#products');
                            }
                        })
                    })
            });

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
                e.preventDefault();
                let _token = $("input[name='_token']").val();
                let name = $('#name').val();
                let details = $('#details').val();
                let comments = $('#comments').val();
                $.ajax({
                    url: '/checkout',
                    type: 'POST',
                    data: {name: name, details: details, comments: comments},
                    success: function () {
                        $('#name').val('');
                        $('#details').val('');
                        $('#comments').val('');
                        $('#name-error').hide();
                        $('#details-error').hide();
                        window.location.assign('#');
                    },
                    error: function (xhr) {
                        var err = JSON.parse(xhr.responseText);
                        $('#name-error').text(err.errors.name);
                        $('#details-error').text(err.errors.details);
                    }
                });
            });

            //Order View
            $(document).on('click', '.order-details', function (e) {
                e.preventDefault();
                let id = $(this).data('id');

                $.ajax('/order/' + id + '', {
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        $('.order .list').html(renderOrder(response));
                        window.location.assign('#order');

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
                        sessionStorage.setItem("title", $('#title').val());
                        sessionStorage.setItem("description", $('#description').val());
                        sessionStorage.setItem("price", $('#price').val());
                        sessionStorage.setItem("image", $('#image').text());
                        sessionStorage.setItem("product-id", $('#product-id').val());
                        window.location.assign('#product');
                    },
                });
            });


            $(document).on('click', '.add-product', function (e) {
                e.preventDefault();
                $('.product-create').show();
                $('.product-update').hide();

                sessionStorage.removeItem("title", $('#title').val());
                sessionStorage.removeItem("description", $('#description').val());
                sessionStorage.removeItem("price", $('#price').val());
                sessionStorage.removeItem("image", $('#image').text());
                sessionStorage.removeItem("product-id", $('#product-id').val());

                $('#product-id').val('');
                $('#title').val('');
                $('#description').val('');
                $('#price').val('');
                $('#image').text('');
                window.location.assign('#product');
            });

            //Product update/ Product add
            $('#product-form').on('submit', function (e) {

                $('#title-error').text('');
                $('#description-error').text('');
                $('#price-error').text('');

                if ($('#product-id').val() != '') {
                    e.preventDefault();
                    let id = $('input[id=product-id]').val();
                    let data = new FormData();
                    data.append('id', id);
                    data.append('title', $('input[id=title]').val());
                    data.append('description', $('input[id=description]').val());
                    data.append('price', $('input[id=price]').val());
                    data.append('_method', 'PUT');

                    if ($('#image').get(0).files.length !== 0) {
                        data.append('image', $('#image')[0].files[0], $('#image')[0].files[0].name);
                    }
                    $.ajax({
                        url: '/products/update/' + id + '',
                        type: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function () {
                            alert('form update was submitetd ')
                            sessionStorage.removeItem("product-id");
                            window.location.assign('#products');
                        },
                        error: function (xhr) {
                            let err = JSON.parse(xhr.responseText);
                            $('#title-error').show();
                            $('#title-error').text(err.errors.title);
                            $('#description-error').show();
                            $('#description-error').text(err.errors.description);
                            $('#price-error').show();
                            $('#price-error').text(err.errors.price);
                            $('#image-error').show();
                            $('#image-error').text(err.errors.image);
                        }
                    });
                } else {
                    e.preventDefault();
                    let data = new FormData();
                    data.append('title', $('input[id=title]').val());
                    data.append('description', $('input[id=description]').val());
                    data.append('price', $('input[id=price]').val());
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
                            $('#product-form')[0].reset();
                            alert('form was submitted');
                            window.location.assign('#products');
                        },
                        error: function (xhr) {
                            let err = JSON.parse(xhr.responseText);
                            $('#title-error').show();
                            $('#title-error').text(err.errors.title);
                            $('#description-error').show();
                            $('#description-error').text(err.errors.description);
                            $('#price-error').show();
                            $('#price-error').text(err.errors.price);
                            $('#image-error').show();
                            $('#image-error').text(err.errors.image);
                        }
                    });
                }
            });

        });
    </script>
</head>
<body>
<div class="page index">
    <table class="list"></table>

    <a href="#cart" class="button">{{__('Cart')}}</a>
    <a href="#products" class="button">{{ __('Go to Products') }}</a>
    <a href="#login" class="button">{{ __('Login') }}</a>
</div>

<div class="page cart">
    <table class="list"></table>
    <form id="checkout-form">
        <div>
            <input id="name" name="name" placeholder="{{ __('Name') }}">
            <p id="name-error"></p>
            <input id="details" name="details" placeholder="{{ __('Email') }}">
            <p id="details-error"></p>
        </div>
        <div>
            <input id="comments" name="comments" placeholder="{{ __('Comments') }}">
            <p id="comments-error"></p>
        </div>
        <button class="submit-order" type="submit">{{__('Checkout') }}</button>
    </form>
    <a href="#" class="button">{{__('Index')}}</a>
    <a href="#products" class="button">{{ __('Products') }}</a>
</div>

<div class="page products">
    <table class="list"></table>
    <div>
        <a href="#product" class="add-product"> {{__('Add Product') }} </a>
        <a href="#cart"> {{__('Cart') }} </a>
        <a href="#index"> {{__('Index') }} </a>
        <a href="#orders"> {{__('Orders') }} </a>
    </div>
</div>
</div>

<div class="page product">
    <form id="product-form" enctype="multipart/form-data">
        <input type="hidden" id="product-id" value="">

        <div>
            <input type="text" id="title" placeholder="{{ __('Enter roduct name') }}" value="">
            <p id="title-error"></p>
        </div>

        <div>
            <input type="text" id="description" placeholder="{{ __('Enter product description') }}" value="">
            <p id="description-error"></p>
        </div>

        <div>
            <input type="number" id="price" placeholder="{{ __('Enter product price') }}" value="">
            <p id="price-error"></p>
        </div>

        <div>
            <input type="file" id="image" value="">
            <p id="image-error"></p>
        </div>

        <button type="submit" class="product-create">{{ __('Create') }}</button>
        <button type="submit" class="product-update">{{ __('Update') }}</button>
    </form>
    <div>
        <a href="#products">{{ __('Products')}}</a>
    </div>
</div>

<div class="page orders">
    <div class="list"></div>
    <div>
        <a href="#products">{{ __('Products') }}</a>
        <a href="#cart">{{__('Cart') }}</a>
        <a href="#index">{{__('Index') }}</a>
    </div>
</div>

<div class="page order">
    <div class="list"></div>
    <div>
        <a href="#orders">{{ __('Orders') }}</a>
    </div>
</div>

<div class="page login">
    <table class="list"></table>
    <form class="#loginForm">
        <div>
            <label>{{ __('Username') }}</label>
            <input type="text" id="username" name="{{ __('User Name') }}" value=""/>
            <p id="username-error"></p>

        </div>
        <div>
            <label>{{ __('Password') }}</label>
            <input type="password" id="password" name="{{ __('Password') }}" value=""/>
            <p id="password-error"></p>
        </div>
        <button class="submit-login" type="submit">{{ __('Login') }}</button>
    </form>
    <a href="#">{{ __('Go to Home') }}</a>
</div>

</body>
</html>
