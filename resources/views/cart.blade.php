@extends('layouts.app')
@section('content')

    <h1>{{__('Cart')}}</h1>

    <div class="container">
        <?php $total = 0; ?>
        @forelse($products as $product)
            <?php $total += $product['price'];?>
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
                <form action="{{ route('cart.destroy',['id'=> $product->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">{{ __('Delete') }}</button>
                </form>

            </ul>
        @empty
        @endforelse
        <P><strong> {{__('Total')}} : {{$total}}</strong></P>
    </div>

    <div class="formular">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <label>{{__('Name')}}</label>
            <input type="text" name="name" value="" required><br>
            <span></span>
            <br>
            <label>{{__('Contact Details')}} </label>
            <input type="text" name="details" value="" required><br>
            <span></span>
            <br>
            <label>{{__('Commebts')}}</label>
            <input type="text" name="comments" value=""><br>
            <span></span>
            <br>
            <input type="submit" name="submit" value="Checkout">
            <p>* {{__('Required fields')}}</p>
        </form>
    </div>
    <a href="{{ route('index') }}"> {{__('Go to index')}}</a>

@endsection
