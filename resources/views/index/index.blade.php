@extends('layouts.app')
@section('content')

    <h1>Index</h1>

    <div class="container">
        @forelse($products as $product)
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ asset('/storage/images/'.$product->image) }}">
                </div>
            </div>
            <ul>
                <li>{{ ucfirst($product->title) }}</li>
                <li>{{ ucfirst($product->description) }}</li>
                <li>{{ ucfirst($product->price) }}</li>
                <li>{{ ucfirst($product->image) }}</li>
                <form action="{{ route('cart.store', $product->id) }}" method="POST">
                    @method('POST')
                    @csrf
                    <button type="submit">{{ __('Add') }}</button>
                </form>
            </ul>
        @empty
        @endforelse
        <a href="{{route('cart.index')}}"> Go to Cart</a>
    </div>

@endsection
