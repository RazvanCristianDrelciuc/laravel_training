@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>Products</h1>
        <?php $total = 0; ?>
        @forelse($products as $product)
            <?php $total += $product['price'];?>
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
                <form action="{{ route('products.edit', $product->id) }}" method="POST">
                    @method('POST')
                    @csrf
                    <button type="submit">{{ __('Edit') }}</button>
                </form>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">{{ __('Delete') }}</button>
                </form>
            </ul>
        @empty
        @endforelse

        <div class="removebutton">
            <a href="{{route('product.create')}}">Add Product</a>
        </div>
    </div>

@endsection
