@extends('layouts.app')
@section('content')

    <div class="formular">
        <form action="{{route('registerUser')}}" method="post">
            @csrf
            @method('PUT')
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <span></span>
            <hr>
            Name: <input type="text" name="user_name" value="" required><br>
            <span></span>
            <br>
            email: <input type="text" name="email" value="" required><br>
            <span></span>
            <br>
            Password: <input type="text" name="password" value="" required><br>
            <span>*</span>
            <br>
            <a href="/login">LogIn</a>
            <div class="removebutton">
                <input type="submit" name="button" value="REGISTER">
            </div>
            <p>* required field</p>
        </form>

@endsection
