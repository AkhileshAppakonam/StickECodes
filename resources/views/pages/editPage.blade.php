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
                            <div class="form-group row mb-0">
                                <div class="container p-0 ml-0">
                                    <label for="chooseSP" class="col-md-0 col-form-label text-md-right">Select a Security Profile</label>
                                    <select id="chooseSP" name="securityProfile" class="form-control">
                                        <option value="SecurityProfile1">Security Profile 1</option>
                                        <option value="SecurityProfile2">Security Profile 2</option>
                                        <option value="SecurityProfile3">Security Profile 3</option>
                                    </select>
                                </div>
                                <div class="or">
                                    <p class="p-0">OR</p>
                                </div>
                                <div class="container p-0 mr-0 makeSP">
                                    <a href="#" class="btn btn-outline-dark">Make a New Security Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 textEntries">
                        <div class="row ml-4">
                            <h2 data-toggle="collapse" data-target="#textCollapse" aria-expanded="false" aria-controls="collapseExample">Text Entries</h2>
                            <div class="collapse" id="textCollapse">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 urlEntries">
                        <div class="row ml-4">
                            <h2 data-toggle="collapse" data-target="#urlCollapse" aria-expanded="false" aria-controls="collapseExample">URLs</h2>
                            <div class="collapse" id="urlCollapse">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 fileEntries">
                        <div class="row ml-4">
                            <h2 data-toggle="collapse" data-target="#fileCollapse" aria-expanded="false" aria-controls="collapseExample">Files</h2>
                            <div class="collapse" id="fileCollapse">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection