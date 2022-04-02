@extends('layouts.app')

@section('content')
    <section id="securityProfiles">
        <form id="securityProfilesForm" name="securityProfilesForm" enctype="multipart/form-data" action="/public/index.php/securityProfiles/deleteSecurityProfile" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>Your Security Profiles</h1></header>

                <div class="ml-1 mb-4">
                    @include('inc.messages')
                </div>
                

                @if (!$user->securityProfiles->isEmpty())
                    @foreach ($user->securityProfiles as $securityProfile)
                        <div class="row shadow mx-3 mb-5 bg-white rounded">
                            <div class="col-md-12 securityProfiles">

                                <div class="container">
                                    <div class="container p-4" onclick="securityProfileHeader(this)">
                                        <h3>{{$securityProfile -> profile_name}}:</h3>
                                        @if (($count = $securityProfile->codes->count()) > 0)
                                            <p>{{$count}} Linked @if ($count > 1) {{"Codes"}} @else {{"Code"}} @endif with {{$securityProfile->security_profile_users->count()}} User Permissions</p>
                                        @else
                                            <p>No Codes Currently Linked</p>
                                        @endif
                                    </div>
                                    <a href="/public/index.php/securityProfilePage/{{$securityProfile -> id}}/editSecurityProfile"><i class='far fa-edit'></i></a>
                                    <button name="delete" type="submit" value="{{$securityProfile -> id}}" class="deleteBtn" onclick="return confirm('Delete this security profile and all of its contents.');"><i class='far fa-trash-alt'></i></button>
                                </div>

                                <div class="row mx-1 collapse">
                                    <div class="col-md-12 px-0 linkedCodesHeader">
                                        <h4>Linked Codes({{$count}})</h4>
                                        <h4>Permissions ({{$securityProfile->security_profile_users->count()}})</h4>
                                    </div>
                                    
                                    <div class="col-md-12 px-0 pr-2 profileDetails">
                                        <div class="card-container">
                                            @if (!$securityProfile->codes->isEmpty())
                                                @foreach ($securityProfile->codes as $code)
                                                    <div class="card">
                                                        <article>
                                                            <figure class="mb-0">
                                                                <div class="image"><img src="{{file_get_contents('/var/www/html/resources/views/QRCodeImageData/'.$code -> code_name.'.png')}}" height="200px" width="200px"></div>
                                                            </figure>
                                                            <div class="description">
                                                                <div class="codeTitles">
                                                                    <h3>{{$code -> code_title}}</h3>
                                                                    <small class="ml-1">{{$code -> code_name}}</small>
                                                                </div>
                                                                <p class="ml-1">{{$code -> pivot -> page_title}}</p>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="card noCodes">
                                                    <article>
                                                        <div class="description">
                                                            <h3>You Have No Linked Codes</h3>
                                                        </div>
                                                    </article>
                                                </div>
                                            @endif
                                            
                                            {{-- <div class="card">
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
                                            </div> --}}
                                        </div>
                                        <div class="permissions py-2 pr-5">
                                            <table>
                                                @foreach ($securityProfile->security_profile_users as $securityProfileUser)
                                                    <tr>
                                                        <td>{{$securityProfileUser -> user -> name}}</td>
                                                        @if ($securityProfileUser -> permissions == 3)
                                                            <td>Full Control</td>
                                                        @elseif ($securityProfileUser -> permissions == 2)
                                                            <td>View and Update</td>
                                                        @else
                                                            <td>View Only</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    @endforeach
                @else
                    <div class="noSecProfiles mb-5">
                        <p class="pl-5">You have No Security Profiles</p>
                    </div>
                @endif
                

                <div class="row mx-3 mb-5 createNew">
                    <div class="col-md-12 newSecurityProfiles px-1">
                        <a href="/public/index.php/securityProfilePage/create" class="py-3">Create New Security Profile <i class="fa fa-plus ml-2"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </section>


    <script type="text/javascript">
        var isclick = true;
        function securityProfileHeader(e) {
            if(isclick){
                isclick = false;
                e.classList.toggle("card-header");
                $(e).parent().next().collapse("toggle");
                setTimeout(function(){
                    isclick = true;
                }, 350)
            }
        }
    </script>
@endsection







