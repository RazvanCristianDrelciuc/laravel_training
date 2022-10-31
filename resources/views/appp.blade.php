<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
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

                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="/images/' + product.image + '" style="width: 100px; height: 100px;" data-image="' + product.image + '"></td>',
                        '</tr>',
                        '</div>',
                    ].join('');

                    switch (window.location.hash) {
                        case '#cart':
                            html += '<td><button class="remove" data-id="' + product.id + '"> Remove from Cart</button></td>';
                            break;
                        case '#products':
                            html += '<td><button class="update" data-id="' + product.id + '"> Update product</button></td>';
                            html += '<td><button class="delete" data-id="' + product.id + '"> Delete product</button></td>';
                            break;
                        default:
                            html += '<td><button class="add" data-id="' + product.id + '"> Add to Cart</button></td>';
                            break;
                    }
                });
                return html;
            }

            var baseUrl = 'http://localhost:8000/api';


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
                                $('.cart .list').html(renderList(response.products));
                            }
                        });
                        break;
                    case '#products':
                        // Show the cart page
                        $('.products').show();
                        // Load the cart products from the server
                        $.ajax('/products', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.products .list').html(renderList(response));
                            }
                        });
                        break;
                    case '#product':
                        if ($('#product-id').val() === '') {
                            $('.product-create').show();
                            $('.product-update').hide();
                        } else {
                            $('.product-create').hide();
                            $('.product-update').show();
                        }
                        // Show the cart page
                        $('.product').show();
                        // Load the cart products from the server
                        $.ajax('/update/', {
                            dataType: 'json',
                            method: 'GET',
                            success: function () {
                                $('.product').show();
                            }
                        });
                        break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/app-index', {
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response.products));
                            }
                        });
                        break;
                }
            }
            //window.onhashchange();
            ///ADD TO CART
            $(document).on('click', '.add', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url:  '/app-add-to-cart/' + id + '',
                    type: 'get',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#products');
                        location.reload();
                    }
                });
            });
            ///REMOVE FROM CART
            window.onhashchange();

            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/remove-from-cart/' + id + '',
                    type: 'get',
                    dataType: 'json',
                    success: function () {
                        //location.reload();
                        window.location.assign('#');
                    }
                });
            });
            ///DELETE PRODUCT
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/delete/' + id + '',
                    type: 'get',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#products');
                    }
                });
            });
            //checkout
            $(document).on('click', '.submit-order', function (e) {
                var _token = $("input[name='_token']").val();
                var name = $('#name').val();
                var details = $('#details').val();
                var comments = $('#comments').val();
                $.ajax({
                    url: '/checkout',
                    type: 'POST',
                    data: {_token: _token, name: name, details: details, comments: comments},
                    success: function () {
                        window.location.assign('#');
                    }
                });
            });
            window.onhashchange();
            $(document).on('click', '.update', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/updateProduct/' + id + '',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $('#product-id').val(response.id);
                        $('#title').val(response.title);
                        $('#description').val(response.description);
                        $('#price').val(response.price);
                        $('#image').text(response.image);
                        window.location.assign('#product');

                    }
                });
            });
            // $(document).on('click', '.product-update', function (e) {
            //     e.preventDefault();
            //     var _token = $("input[name='_token']").val();
            //     var id = $(this).data('id');
            //     var title = $('#title').val();
            //     var description = $('#description').val();
            //     var price = $('#price').val();
            //     // var image =$('#image').val();
            //     $.ajax({
            //         url: '/update/' + id ,
            //         type: 'Put',
            //         data: {_token:_token, title: title, description: description, price: price},
            //         success: function (response) {
            //             window.location.assign('#products');
            //
            //         }
            //     });
            // });
            $(document).on('click', '.product-update', function (e) {
                e.preventDefault();
                let id = $('input[id=product-id]').val();
                let data = new FormData();
                data.append('id', id);
                data.append('title', $('input[id=title]').val());
                data.append('description', $('input[id=description]').val());
                data.append('price', $('input[id=price]').val());
                if ($('#image').get(0).files.length !== 0) {
                    data.append('image', $('#image')[0].files[0]);
                }
                $.ajax({
                    url: '/update/' + id + '',
                    type: 'PUT',
                    dataType: 'json',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('.product-form')[0].reset();
                        window.location.assign('#products');
                    }
                });
            })
            window.onhashchange();
            $(document).on('click', '.product-create', function (e) {
                e.preventDefault();
                let data = new FormData();
                data.append('title', $('input[id=title]').val());
                data.append('description', $('input[id=description]').val());
                data.append('price', $('input[id=price]').val());
                if ($('#image').get(0).files.length !== 0) {
                    data.append('image', $('#image')[0].files[0]);
                }
                $.ajax({
                    url: '/Add' ,
                    type: 'PUT',
                    dataType: 'json',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('.product-form')[0].reset();
                        window.location.assign('#products');
                    }
                });
            })

            // $(document).on('click', '.product-create', function (e) {
            //     var _token = $("input[name='_token']").val();
            //     var title = $('#title').val();
            //     var description = $('#description').val();
            //     var price = $('#price').val();
            //     $.ajax({
            //         url: '/Add',
            //         type: 'POST',
            //         data: {_token: _token, title: title, description: description, price: price},
            //         success: function () {
            //             window.location.assign('#products');
            //         }
            //     });
            // });
            window.onhashchange();

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
    </div>
</div></div>

<div class="page product">
    <form class="product-form" enctype="multipart/form-data">
        {{csrf_field()}}
        <div>
            <input type="text" id="title" placeholder=" Enter product title " value="">
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
        <input type="hidden" id="product-id" value="">
        <button type="button" class="product-create"> Create</button>
        <button type="button" class="product-update"> Update</button>
    </form>
    <div>
        <a href="#products"> {{__('Products')}} </a>
    </div>
</div>


</body>
</html>
