@extends('layouts.app')

@section('content')
<div class="container">
    <header class="mb-2"><h1>Your Codes</h1></header>
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-4">
            <article class="dashboardCodes">
                <figure class="mb-0">
                    <div class="image"><a href="#"><img src="../images/stickecode.png"></a></div>
                </figure>
                <div class="description">
                    <h3>Insert Title Here</h3>
                    <p>Insert Title Description of Public Page Here</p>
                    <hr>
                    <div>
                        <a href="#" class="btn btn-outline-dark">View Page</a>
                        <a href="#" class="btn btn-outline-dark float-right">Edit Page</a>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-md-4 col-sm-4">
            <article class="dashboardCodes">
                <figure class="mb-0">
                    <div class="image"><a href="#"><img src="../images/stickecode.png"></a></div>
                </figure>
                <div class="description">
                    <h3>Insert Title Here</h3>
                    <p>Insert Title Description of Public Page Here</p>
                    <hr>
                    <div>
                        <a href="#" class="btn btn-outline-dark">View Page</a>
                        <a href="#" class="btn btn-outline-dark float-right">Edit Page</a>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-md-4 col-sm-4">
            <article class="dashboardCodes">
                <figure class="mb-0">
                    <div class="image"><a href="#"><img src="../images/stickecode.png"></a></div>
                </figure>
                <div class="description">
                    <h3>Insert Title Here</h3>
                    <p>Insert Title Description of Public Page Here</p>
                    <hr>
                    <div>
                        <a href="#" class="btn btn-outline-dark">View Page</a>
                        <a href="#" class="btn btn-outline-dark float-right">Edit Page</a>
                    </div>
                </div>
            </article>
        </div>
        
        
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
    </div>
</div>
@endsection
