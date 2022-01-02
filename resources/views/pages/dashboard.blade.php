@extends('layouts.app')

@section('content')
    <section id="dashboard">
        <form id="dashboardForm" name="dashboardForm" enctype="multipart/form-data" action="" method="POST">
            @csrf

            <div class="container">
                <header class="mb-3"><h1>Your Codes</h1></header>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @include('inc.messages')

                <div class="row justify-content-left ml-2">
                    @if (!$user->codes->isEmpty())
                        @foreach ($user->codes as $code)
                            <div class="col-md-4 col-sm-4">
                                <article class="dashboardCodes shadow-lg p-3 mb-5 bg-white rounded">
                                    <figure class="mb-0">
                                        <div class="image"><a href="/public/index.php/pages/{{$user -> name}}/{{$code -> code_name}}"><img src="{{file_get_contents('/var/www/html/resources/views/QRCodeImageData/'.$code -> code_name.'.png')}}" alt='QR Code' width='300' height='300'></a></div>
                                    </figure>
                                    <div class="description pb-4">
                                        <div class="codeTitles">
                                            <h3>{{$code -> code_title}}</h3>
                                            <small class="ml-1">{{$code -> code_name}}</small>
                                        </div>
                                        @foreach ($code->pages as $page)
                                            <p class="ml-1 py-1">{{$page -> page_title}}</p>
                                        @endforeach
                                        <hr>
                                        <div class="container">
                                            <a href="/public/index.php/pages/{{$user -> name}}/{{$code -> code_name}}"><i class="fas fa-eye"></i></a>

                                            @can('editPage', $code)
                                                <a href="/public/index.php/codes/{{$code -> id}}/editPage"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            
                                            @foreach ($code->pages as $page)
                                                @isset($page->security_profile)
                                                    @can('editSecurityProfile', $page->security_profile)
                                                        <a href="/public/index.php/securityProfilePage/{{$page -> security_profile_id}}/editSecurityProfile"><i class="fas fa-user-shield"></i></a>
                                                    @endcan
                                                @endisset
                                            @endforeach

                                            <button name="delete" type="submit" value="{{$code -> id}}" class="deleteBtn" onclick="return confirm('Delete this code profile and all of its contents.');"><i class='fas fa-trash'></i></button>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @else
                        <p>You have No Codes</p>
                    @endif
                    
                </div>

                <div>
                    <a href="/public/index.php/createCode">Generate New QR Code</a>
                </div>
            </div>
        </form>
    </section>
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