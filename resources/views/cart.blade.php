@extends('layouts.app')
@section('content')

    <h1>{{ __('Cart') }}</h1>

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
                <form action="{{ route('cart.destroy',['product'=> $product->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">{{ __('Delete') }}</button>
                </form>

            </ul>
        @empty
            <div>
                <p>{{ __('Cart is empty') }}</p>
            </div>
        @endforelse
    </div>
    @if (!empty($products))
    <div class="formular">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" value="" class="@error('name') is-invalid @enderror" ><br>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label>{{ __('Contact Details') }} </label>
            <input type="text" name="details" value="" class="@error('details') is-invalid @enderror"><br>
            @error('details')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label>{{ __('Comments') }}</label>
            <input type="text" name="comments" value="" class="@error('comments') is-invalid @enderror"><br>
            @error('comments')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="submit" name="submit" value="Checkout">
            <p> {{ __('Required fields') }}</p>
        </form>
    </div>
    @endif
    <a href="{{ route('index') }}"> {{ __('Go to index') }}</a>

@endsection
