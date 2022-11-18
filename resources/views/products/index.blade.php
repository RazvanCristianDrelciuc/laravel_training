@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>{{ __('Products') }}</h1>
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

                <a href="{{ route('products.edit', ['product'=> $product->id]) }}">{{ __('Edit Product') }}</a>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">{{ __('Delete') }}</button>
                </form>
            </ul>
        @empty
            <div>
                <p>{{ __('There are no products.') }}</p>
            </div>
        @endforelse

        <div class="removebutton">
            <a href="{{ route('products.create') }}">{{ __('Add Product') }}</a>
        </div>
    </div>

@endsection
