@extends('layouts.app')

@section('content')
    <section id="viewFile">
        <div class="container">
            <header class="mb-3"><h1>{{$file -> entry_description}}</h1></header>
            <h3 class="mb-5">{{$file -> file}}</h3>

            <div class="fileImage mt-5">
                <img src="/storage/app/public/user_files/{{$file -> file}}" alt="{{$file -> entry_description}}" width="500" height="500">
            </div>

            <div class="pt-2">
                <p>Entry Date: {{$file -> entry_date}}</p>
            </div>
        </div>
    </section>
@endsection