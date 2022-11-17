@extends('layouts.app')
@section('content')

    <div class="container">

        <h1>{{__('Order')}}</h1>
        <h3>{{__('Order Id')}}: {{$order->id}}</h3>
        <h3>{{__('User Name')}}: {{$order->user_name}}</h3>
        <h3>{{__('Details')}}: {{$order->details}}</h3>
        <h3>{{__('Total Price')}}: {{$order->price}}</h3>

        @foreach ($order->products as $product)
            <div>
                <h4>{{__('Title')}}: {{ $product->title }}</h4>
                <h4>{{__('Description')}}: {{ $product->description }}</h4>
                <h4>{{__('Price')}}: {{ $product->price }} </h4>
            </div>
        @endforeach
    </div>
@endsection
