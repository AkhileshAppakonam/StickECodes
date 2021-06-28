@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    <p>This is a test Laravel Application for StickEcodes</p>

    <script>
        var home = document.getElementById('home');

        home.classList.add('active');
    </script>
@endsection