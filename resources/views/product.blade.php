@extends('layouts.app')
@section('content')

    <div class="formular">
        <form action="" method="post">
            @csrf
            <label>Name</label>
            <input type="text" name="name" value="{{$product['title']}}" required><br>
            <span ></span>
            <br>
            <label>Contact Details: </label>
            <input type="text" name="details" value="" required><br>
            <span ></span>
            <br>
            <label>Comments: </label>
            <input type="text" name="comments" value=""><br>
            <span ></span>
            <br>
            <input type="submit" name="submit" value="Checkout">
            <p>* required field</p>
        </form>
    </div>
    <a href="/index"> Go to Index</a>
