@extends('layouts.app')
@section('content')

    <h1>Cart</h1>

    <div class="container">
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
                <form action="{{ route('cart.destroy',['id'=> $product->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">{{ __('Delete') }}</button>
                </form>

            </ul>
        @empty
        @endforelse
        <P><strong> Total : {{$total}}</strong></P>
    </div>

    <div class="formular">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <label>Name</label>
            <input type="text" name="name" value="" required><br>
            <span></span>
            <br>
            <label>Contact Details: </label>
            <input type="text" name="details" value="" required><br>
            <span></span>
            <br>
            <label>Comments: </label>
            <input type="text" name="comments" value=""><br>
            <span></span>
            <br>
            <input type="submit" name="submit" value="Checkout">
            <p>* required field</p>
        </form>
    </div>
    <a href="{{ route('index') }}"> Go to Index</a>

@endsection
