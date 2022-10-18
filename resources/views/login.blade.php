@extends('layouts.app')
@section('content')

    <div class="formular">
        <form action="{{route('loginUser')}}" method="post">
            @csrf
            @method('PUT')
            <h1>LogIn</h1>
            <p>Please fill in this form to connect to an account.</p>
            <span></span>
            <hr>
            Name: <input type="text" name="name" value="" required><br>
            <span></span>
            <br>
            Password: <input type="text" name="password" value="" required><br>
            <span>*</span>
            <br>
            <div class="removebutton">
                <input type="submit" name="button" value="LOGIN">
            </div>
            <p>* required field</p>
        </form>
    </div>

@endsection
