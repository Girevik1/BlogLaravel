@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="alert alert-success" style="display:none"></div>
        <form id="myForm">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" class="form-control" name="type" id="type">
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" name="price" id="price">
            </div>
            <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
        </form>
    </div>

@endsection



