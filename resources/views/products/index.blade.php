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
                <div class="removebutton">
                    <a href="{{ route('product.destroy',['id' => $product->id])  }}" name="remove">Remove Product</a>
                </div>
                <div class="removebutton">
                    <a href="{{ route('product.edit',['id' => $product->id])  }}" name="remove">Update Product</a>
                </div>
            </ul>
        @empty
        @endforelse
        <div class="removebutton">
            <a href="{{route('product.create')}}">Add Product</a>
        </div>
    </div>

@endsection
