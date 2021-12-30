@extends('layouts.app')

@section('content')
    <section id="codeLookUp">
        <form id="codeLookUpForm" name="codeLookUpForm" enctype="multipart/form-data" action="/public/index.php/codes/lookUp" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>Enter a Code</h1></header>

                @include('inc.messages')

                <video id="video" width="640" height="480" autoplay></video>

                <input type="text" class="form-control my-3" name="codeName" pattern=".{5,}" placeholder="Please enter the 5 digit code name" required>
                <input type="submit" class="btn btn-primary" value="Look Up Code">
            </div>
        </form>
    </section>

    <script>
        var video = document.getElementById('video');

        // Get access to the camera!
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Not adding `{ audio: true }` since we only want video now
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                //video.src = window.URL.createObjectURL(stream);
                video.srcObject = stream;
                video.play();
            });
        }
    </script>
@endsection