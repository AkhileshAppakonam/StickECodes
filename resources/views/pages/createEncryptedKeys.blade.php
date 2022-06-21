@extends('layouts.app')

@section('content')
    <section id="createEncryptedKeys">
        <form id="encryptionKeysForm" name="encryptionKeysForm" enctype="multipart/form-data" action="#" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>Create Encrypted Key</h1></header>

                <div class="ml-1 mb-4">
                    @include('inc.messages')
                </div>


            </div>
        </form>
    </section>
@endsection