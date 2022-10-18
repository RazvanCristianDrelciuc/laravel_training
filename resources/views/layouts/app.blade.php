<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body>
<div class="nav">
    <ul>
        <li><a href="/index">Index</a></li>
        <li><a href="/cart">Cart</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/register">Register</a></li>
        <li><a href="/orders">Orders</a></li>

        {{--        <!--        --><?php //if($_SESSION['admin'] == 1) { ?>--}}
        {{--        <li><a href="products.php">PRODUCTS</a></li>--}}
        {{--        <li><a href="product.php">PRODUCT</a></li>--}}
        {{--        <li><a href="orders.php">ORDERS</a></li>--}}
        {{--<!--        --><?php //} ?>--}}
    </ul>
</div>
@yield('content')

</body>
</html>
