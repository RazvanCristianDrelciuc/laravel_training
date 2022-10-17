@extends('layouts.app')
@section('content')



    <div class="container">
        <?php $total=0; ?>
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
                    <a href="{{ route('deleteProduct',['id' => $product->id])  }}"  name="remove">Remove Product</a>
                </div>

                <div class="removebutton">
                    <a href="{{ route('updateProduct',['id' => $product->id])  }}"  name="remove">UPDATE</a>
                </div>

            </ul>
    @empty
    @endforelse
            <div class="removebutton">
                <a href="/AddProduct">AddProduct</a>
            </div>


@endsection
