@extends('layouts.app')
@section('content')

    <div class="container">
        <form action="{{isset($product) ? route('product.update',['id' => $product->id]) : route('product.store')}}" method="post">
            @csrf
            @isset ($product)
                @method('PUT')
            @endisset
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ isset($product) ? asset('/storage/images/'.$product->image) : '' }}">
                </div>
            </div>
            <label>Product Title</label>
            <input type="text" name="title" value="{{isset($product) ? ($product['title']) : ''}}" required><br>
            <span></span>
            <br>
            <label>Description </label>
            <input type="text" name="description" value="{{isset($product) ? ($product['description']) : ''}}" required><br>
            <span></span>
            <br>
            <label>Price </label>
            <input type="text" name="price" value="{{isset($product) ? ($product['price']) : ''}}"><br>
            <span></span>
            <br>
            <label>Price </label>
            <input type="file" class="form-control" required name="image">
            <span></span>
            <br>
            @if(isset($product))
                <div class="removebutton">
                    <input type="submit" name="button" value="update">
                </div>
            @else
                <div class="removebutton">
                    <input type="submit" name="button" value="Add">
                </div>
            @endif
            <p>* required field</p>
        </form>
    </div>
    <a href="{{ route('index') }}"> Go to Index</a>

@endsection
