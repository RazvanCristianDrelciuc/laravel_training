@extends('layouts.app')
@section('content')

    <h1>Index</h1>

    <div class="container">
        @forelse($products as $product)
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ asset('/images/'.$product->image) }}">
                </div>
            </div>
            <ul>
                <li>{{ ucfirst($product->title) }}</li>
                <li>{{ ucfirst($product->description) }}</li>
                <li>{{ ucfirst($product->price) }}</li>
                <li>{{ ucfirst($product->image) }}</li>
                <div class="addbutton">
                    <a href="{{ route('cart.store',['id' => $product->id])  }}" name="add">Add</a>
                </div>
            </ul>
        @empty
        @endforelse
        <a href="{{route('cart.index')}}"> Go to Cart</a>
    </div>

@endsection
