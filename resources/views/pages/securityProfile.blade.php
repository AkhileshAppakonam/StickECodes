@extends('layouts.app')

@section('content')
    <section id="securityProfiles">
        <div class="container">
            <header class="mb-5"><h1>Your Security Profiles</h1></header>

            <div class="row shadow-lg ml-5 mr-3 mb-5 bg-white rounded">
                <div class="col-md-12 securityProfiles">
                    <div class="container py-3 px-4" data-toggle="collapse" data-target="#securityProfile" aria-expanded="false" aria-controls="collapseExample" onclick="securityProfileHeader(this)">
                        <h3>Security Profile 1</h3>
                        <a href="" class="btn btn-primary" onclick="stopProp(this)">Edit Security Profile</a>
                    </div>
                    <div class="row mx-1 collapse" id="securityProfile">
                        <div class="col-md-12 px-0 linkedCodesHeader">
                            <h4>Linked Codes (4)</h4>
                            <h4>Permissions (5)</h4>
                        </div>
                        <div class="col-md-12 px-0 pr-2 profileDetails">
                            <div class="card-container">
                                <div class="card">
                                    <article>
                                        <figure class="mb-0">
                                            <div class="image"><img src="../images/stickecode.png" height="200px" width="200px"></div>
                                        </figure>
                                        <div class="description">
                                            <div class="codeTitles">
                                                <h3>Code Title</h3>
                                                <small class="ml-1">XXXX</small>
                                            </div>
                                            <p class="ml-1">Insert Title Description for Public Page Here</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="card">
                                    <article>
                                        <figure class="mb-0">
                                            <div class="image"><img src="../images/stickecode.png" height="200px" width="200px"></div>
                                        </figure>
                                        <div class="description">
                                            <div class="codeTitles">
                                                <h3>Code Title</h3>
                                                <small class="ml-1">XXXX</small>
                                            </div>
                                            <p class="ml-1">Insert Title Description for Public Page Here</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="card">
                                    <article>
                                        <figure class="mb-0">
                                            <div class="image"><img src="../images/stickecode.png" height="200px" width="200px"></div>
                                        </figure>
                                        <div class="description">
                                            <div class="codeTitles">
                                                <h3>Code Title</h3>
                                                <small class="ml-1">XXXX</small>
                                            </div>
                                            <p class="ml-1">Insert Title Description for Public Page Here</p>
                                        </div>
                                    </article>
                                </div>
                                <div class="card">
                                    <article>
                                        <figure class="mb-0">
                                            <div class="image"><img src="../images/stickecode.png" height="200px" width="200px"></div>
                                        </figure>
                                        <div class="description">
                                            <div class="codeTitles">
                                                <h3>Code Title</h3>
                                                <small class="ml-1">XXXX</small>
                                            </div>
                                            <p class="ml-1">Insert Title Description for Public Page Here</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="permissions py-2 pr-5">
                                <table>
                                    <tr>
                                        <th>1.</th>
                                        <th>User 1</th>
                                        <th>Full Control</th>
                                    </tr>
                                    <tr>
                                        <th>2.</th>
                                        <th>User 2</th>
                                        <th>View and Update</th>
                                    </tr>
                                    <tr>
                                        <th>3.</th>
                                        <th>User 3</th>
                                        <th>View Only</th>
                                    </tr>
                                    <tr>
                                        <th>4.</th>
                                        <th>User 4</th>
                                        <th>View and Update</th>
                                    </tr>
                                    <tr>
                                        <th>5.</th>
                                        <th>User 5</th>
                                        <th>Full Control</th>
                                    </tr>
                                    <tr>
                                        <th>1.</th>
                                        <th>User 1</th>
                                        <th>Full Control</th>
                                    </tr>
                                    <tr>
                                        <th>2.</th>
                                        <th>User 2</th>
                                        <th>View and Update</th>
                                    </tr>
                                    <tr>
                                        <th>3.</th>
                                        <th>User 3</th>
                                        <th>View Only</th>
                                    </tr>
                                    <tr>
                                        <th>4.</th>
                                        <th>User 4</th>
                                        <th>View and Update</th>
                                    </tr>
                                    <tr>
                                        <th>5.</th>
                                        <th>User 5</th>
                                        <th>Full Control</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>


    <script type="text/javascript">
        var isclick = true;
        function securityProfileHeader(e) {
            if(isclick){
                isclick = false;
                e.classList.toggle("card-header");
                setTimeout(function(){
                    isclick = true;
                }, 350)
            }
        }

        function stopProp(e) {
            $('#securityProfiles .container .securityProfiles .container').removeAttr('data-toggle');
            $('#securityProfiles .container .securityProfiles .container').removeAttr('onclick');
        }
    </script>
@endsection