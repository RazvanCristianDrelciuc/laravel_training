@extends('layouts.app')
@section('content')

    <div class="container">

        <h1>Order</h1>
        <h3>Order ID: {{$order->id}}</h3>
        <h3>User name: {{$order->user_name}}</h3>
        <h3>Order Details: {{$order->details}}</h3>
        <h3>Total price: {{$order->price}}</h3>

        @foreach ($order->products as $product)
            <div>
                <h4>Title: {{ $product->title }}</h4>
                <h4>Description: {{ $product->description }}</h4>
                <h4>Price: {{ $product->price }} </h4>
            </div>
        @endforeach
    </div>
@endsection
