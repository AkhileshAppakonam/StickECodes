@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    <p>This is the ABOUT US Page</p>

    <script>
        var about = document.getElementById('about');

        about.classList.add('active');
    </script>
@endsection