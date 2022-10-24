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
                // if (window.location.hash === '#products') {
                //     html += [
                //         '<th colspan="2"> Action </th>',
                //         '</tr>'
                //     ].join('');
                // } else {
                //     html += [
                //         '<th> Action </th>',
                //         '</tr>',
                //         '</thead>'
                //     ].join('');
                // }

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
                            //html +='</div>';
                            break;
                    }
                });

                return html;
            }
            // html += '<td><img src="storage/images/' + product.image + '" style="width: 100px; height: 100px;" data-image="' + product.image + '"></td>';

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
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/products', {
                            dataType: 'json',
                            method: 'GET',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response));
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
            ///ADD TO CART
            $(document).on('click', '.add', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/app-add-to-cart/' + id + '',
                    type: 'get',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#cart');
                    }
                });
            });
            ///REMOVE FROM CART
            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '/remove-from-cart/' + id + '',
                    type: 'get',
                    dataType: 'json',
                    success: function () {
                        window.location.assign('#cart');
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
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
    <a href="#cart" class="button">Go to cart</a>
    <a href="#products" class="button">Go to products</a>
    <a href="#login" class="button">Login</a>
</div>

<div class="page products">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
    <a href="#cart" class="button">Go to cart</a>
    <a href="#login" class="button">Login</a>
</div>

</body>
</html>
