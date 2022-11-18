@extends('layouts.app')
@section('content')

    <div class="container">
        <form action="{{ isset($product) ? route('products.update',['product' => $product->id]) : route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @isset ($product)
                @method('PUT')
            @endisset
            <div class="proditem">
                <div class="prodimage">
                    <img src="{{ isset($product) ? asset('/storage/images/'.$product->image) : '' }}">
                </div>
            </div>
            <label>{{ __('Product Title') }}</label>
            <input type="text" name="title" class="@error('title') is-invalid @enderror" value="{{ isset($product) ? ($product['title']) : '' }}" ><br>
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label>{{ __('Description') }} </label>
            <input type="text" name="description" class="@error('description') is-invalid @enderror" value="{{ isset($product) ? ($product['description']) : '' }}" ><br>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label>{{ __('Price') }} </label>
            <input type="text" name="price" class="@error('price') is-invalid @enderror" value="{{ isset($product) ? ($product['price']) : '' }}"><br>
            @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <br>
            <label>{{ __('Image') }} </label>
            <input type="file" class="form-control"  name="image" value="{{ isset($product) ? ($product['image']) : '' }}">
            <span></span>
            <br>
            <button type="submit" name="button" >{{ isset($product) ? __('Update Button') : __('Add Button') }}</button>
            <p>{{ __('Required fields') }}</p>
        </form>
    </div>
    <a href="{{ route('index') }}"> {{ __('Go to index') }}</a>

@endsection
