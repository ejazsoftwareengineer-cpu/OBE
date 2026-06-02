<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>Error Message</title>
        @extends('layouts.backend.app')

        @section('content')

        <div class="error-box mt-5">
          <h1>{{$error}}</h1>
          <h3><i class="fa fa-warning"></i>{{$heading}}</h3>
          <p>{{$message}}</p>
          <a href="{{route('home')}}" class="btn btn-custom">Back to Home</a>
        </div>
        @endsection

        @section('script')

        @endsection
