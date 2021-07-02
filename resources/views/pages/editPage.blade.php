@extends('layouts.app')

@section('content')
    <section id="editPage">
        <div class="container">
            <header class="mb-4"><h1>{{$code -> code_name ." ". $code -> code_title}}</h1></header>

            <div class="row">
                <div class="col-md-4 code">
                    <figure class="mb-0">
                        <div class="image"><a href="#"><img src="../../../images/stickecode.png"></a></div>
                    </figure>
                </div>
                <div class="col-md-8 codeProperties">
                    
                </div>
            </div>
        </div>
    </section>
@endsection