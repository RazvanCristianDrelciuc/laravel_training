@extends('layouts.app')
@section('content')

    <h1>Order</h1>
        <h3>Order ID: {{$order->id}}</h3>
        <h3>User name: {{$order->user_name}}</h3>
        <h3>Order Details: {{$order->details}}</h3>
        <h3>Total price: {{$order->price}}</h3>
        <div class="container">
        <?php $ct = 0; ?>
        @forelse($items as $item)
            <?php $ct++; ?>
            <ul>
                <li><strong>Product nr: {{$ct}}</strong></li>
                <li>Product title: {{ $item['item_title'] }}</li>
                <li>Product description: {{ $item['item_description']}}</li>
                <li>Product price: {{ $item['item_price'] }}</li>
            </ul>
        @empty
        @endforelse
    </div>
@endsection
