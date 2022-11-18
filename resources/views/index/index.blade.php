@extends('layouts.app')
@section('content')

    <h1>{{ __('Index') }}</h1>

    <div class="container">
        @forelse($products as $product)
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ asset('/storage/images/'.$product->image) }}">
                </div>
            </div>
            <ul>
                <li>{{ $product->title }}</li>
                <li>{{ $product->description }}</li>
                <li>{{ $product->price }}</li>
                <form action="{{ route('cart.store')}}" method="POST">
                    @csrf
                    <button type="submit">{{ __('ADD') }}</button>
                    <input type="hidden" name="id_product" value="{{ $product->id }}">
                </form>
            </ul>
        @empty
            <div>
                <p>{{ __('There are no products') }}</p>
            </div>
        @endforelse
        <a href="{{ route('cart.index') }}"> {{ __('Go to cart') }}</a>
    </div>

@endsection
