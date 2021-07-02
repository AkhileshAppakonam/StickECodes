@extends('layouts.app')

@section('content')
    <section id="editPage">
        <form id="editPageForm" name="editPageForm" enctype="multipart/form-data" action="" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>{{$code -> code_name ." ". $code -> code_title}}</h1></header>

                <div class="row shadow p-3 mb-5 bg-white rounded">
                    <div class="col-md-4 code">
                        <figure class="mb-0">
                            <div class="image"><a href="#"><img src="../../../images/stickecode.png"></a></div>
                        </figure>
                    </div>
                    <div class="col-md-8 codeProperties">
                        <div class="container"> 
                            <div class="form-group row">
                                <label for="codeTitle" class="col-md-0 col-form-label text-md-right">Code Title</label>
                                <input id="codeTitle" type="text" class="form-control" value="{{$code -> code_title}}" required>
                            </div>
                            <div class="form-group row">
                                <label for="pageTitle" class="col-md-0 col-form-label text-md-right">Page Title</label>
                                <input id="pageTitle" type="text" class="form-control" placeholder="Insert Title Description for Public Page Here" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection