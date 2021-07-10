@extends('layouts.app')

@section('content')
    <section id="securityProfiles">
        <div class="container">
            <header class="mb-5"><h1>Your Security Profiles</h1></header>

            <div class="row shadow-lg ml-5 mr-3 mb-5 bg-lightblue rounded">
                <div class="col-md-12 securityProfiles">
                    <div class="container py-3 px-4" data-toggle="collapse" data-target="#securityProfile" aria-expanded="false" aria-controls="collapseExample" onclick="securityProfileHeader(this)">
                        <h3>This is a test</h3>
                        <a href="" class="btn btn-outline-dark">Edit Security Profile</a>
                    </div>
                    <div class="row mx-1 collapse" id="securityProfile">
                        <div class="col-md-3 securityProfileCode">
                            
                        </div>
                        <div class="col-md-3 securityProfileCode">
                            <figure class="mb-0">
                                <div class="image"><img src="../images/stickecode.png" height="200px" width="200px"></div>
                            </figure>
                        </div>
                        <div class="col-md-3 securityProfileCode">
                            
                        </div>
                        <div class="col-md-3 securityProfileCode">
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <script type="text/javascript">
        function securityProfileHeader(e) {
            e.classList.toggle("card-header");
        }
    </script>
@endsection