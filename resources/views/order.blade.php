@extends('layouts.app')
@section('content')

    <h1>Order</h1>
        <h3>Order ID: {{$order->id}}</h3>
        <h3>User name: {{$order->user_name}}</h3>
        <h3>Order Details: {{$order->details}}</h3>
        <h3>Total price: {{$order->price}}</h3>
        <div class="container">
        <?php $ct = 0; ?>
            @foreach ($order->products as $product)
                <div>
                    <h4>{{ __('Title') }}: {{ $product->title }}</h4>
                    <h4>{{ __('Description') }}: {{ $product->description }}</h4>
                    <h4>{{ __('Price') }}: {{ $product->price }} </h4>
                </div>
            @endforeach
    </div>
@endsection
