@extends('layouts.app')

@section('content')
    <section id="encryptedKeys">
        <div class="containe">
            <header class="mb-4"><h1>Your Encrypted Keys</h1></header>

            <div class="ml-1 mb-4">
                @include('inc.messages')
            </div>

            <div class="row mx-3 mb-5">
                <div class="col-md-12 px-1">
                    <a href="/public/index.php/keys/create" class="py-3">Create New Encrypted Key<i class="fa fa-key ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection