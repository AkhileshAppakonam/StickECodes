@extends('layouts.app')

@section('content')
<div class="container">
    <header class="mb-3"><h1>Your Codes</h1></header>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center">
        @if (count($codes) > 0)
            @foreach ($codes as $code)
                <div class="col-md-4 col-sm-4">
                    <article class="dashboardCodes shadow-lg p-3 mb-5 bg-white rounded">
                        <figure class="mb-0">
                            <div class="image"><a href="#"><img src="../images/stickecode.png"></a></div>
                        </figure>
                        <div class="description px-5 pb-5">
                            <div class="codeTitles">
                                <h3>{{$code -> code_title}}</h3>
                                <small class="ml-1">{{$code -> code_name}}</small>
                            </div>
                            <p class="ml-1">Insert Title Description for Public Page Here</p>
                            <hr>
                            <div>
                                <a href="#" class="btn btn-outline-dark">View Page</a>
                                <a href="/public/index.php/codes/{{$code -> id}}/editPage" class="btn btn-outline-dark float-right">Edit Page</a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        @else
            <p>You have No Codes</p>
        @endif
        
    </div>
</div>
@endsection

{{-- <div class="col-md-12">
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}
        </div>
     </div>
</div> --}}