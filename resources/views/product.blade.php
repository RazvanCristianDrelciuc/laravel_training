@extends('layouts.app')
@section('content')

    <div class="container">
        <form action="{{isset($product) ? route('product.update',['id' => $product->id]) : route('product.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @isset ($product)
                @method('PUT')
            @endisset
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ isset($product) ? asset('/storage/images/'.$product->image) : '' }}">
                </div>
            </div>
            <label>{{__('Product Title')}}</label>
            <input type="text" name="title" value="{{isset($product) ? ($product['title']) : ''}}" required><br>
            <span></span>
            <br>
            <label>{{__('Description')}} </label>
            <input type="text" name="description" value="{{isset($product) ? ($product['description']) : ''}}" required><br>
            <span></span>
            <br>
            <label>{{__('Price')}} </label>
            <input type="text" name="price" value="{{isset($product) ? ($product['price']) : ''}}"><br>
            <span></span>
            <br>
            <label>{{__('Price')}} </label>
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
            <p>* {{__('Required fields')}}</p>
        </form>
    </div>
    <a href="{{ route('index') }}"> {{__('Go to index')}}</a>

@endsection
