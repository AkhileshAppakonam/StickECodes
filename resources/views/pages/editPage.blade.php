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
                                    <a href="#" class="btn btn-primary">Make a New Security Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 textEntries">
                        <div class="row ml-4">
                            <h2 class="fromLeft pb-3 m-0" data-toggle="collapse" data-target="#textCollapse" aria-expanded="false" aria-controls="collapseExample" onclick="textEntriesDropdown()">Text Entries <i id="textEntries" class="far fa-plus-square ml-2 float-right mr-5 mt-2"></i></h2>
                            <div class="collapse" id="textCollapse">
                                <hr class="mt-0">
                                
                                <table class="mx-5" id="textTable">
                                    <tr class="mb-3 pb-2 border-bottom">
                                        <th>Text Title</th>
                                        <th class="textBody">Text</th>
                                        <th class="rowInput">Remove Row</th>
                                    </tr>
                                    <tr class="mb-2 pb-2 border-bottom">
                                        <td><input type="text" class="form-control" placeholder="Insert Text Title Here"></td>
                                        <td class="textBody"><textarea name="textBody" placeholder="Insert Text Body Here" class="form-control"></textarea></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>

                                <div class="mx-5 py-2 mb-4">
                                    <input type="button" value="Add More Text" class="add btn btn-primary" onclick="addText()">
                                </div>
                            </div>
                        </div>
                        <hr class="ml-4 mt-0">
                    </div>

                    <div class="form-group col-12 urlEntries">
                        <div class="row ml-4">
                            <h2 class="fromLeft pb-3 m-0" data-toggle="collapse" data-target="#urlCollapse" aria-expanded="false" aria-controls="collapseExample" onclick="urlEntriesDropdown()">URLs <i id="urlEntries" class="far fa-plus-square ml-2 float-right mr-5 mt-2"></i></h2>
                            <div class="collapse" id="urlCollapse">
                                <hr class="mt-0">
                                
                                <table class="mx-5" id="urlTable">
                                    <tr class="mb-3 pb-2 border-bottom">
                                        <th>URL Description</th>
                                        <th class="textBody">URL</th>
                                        <th class="rowInput">Remove Row</th>
                                    </tr>
                                    <tr class="mb-2 pb-3 border-bottom">
                                        <td><input type="text" class="form-control" placeholder="Insert URL Description Here"></td>
                                        <td class="textBody"><input type="text" class="form-control" placeholder="Insert URL Here"></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>

                                <div class="mx-5 py-2 mb-4">
                                    <input type="button" value="Add Another URL" class="add btn btn-primary" onclick="addURL()">
                                </div>
                            </div>
                        </div>
                        <hr class="ml-4 mt-0">
                    </div>

                    <div class="form-group col-12 fileEntries">
                        <div class="row ml-4">
                            <h2 class="fromLeft pb-3 m-0" data-toggle="collapse" data-target="#fileCollapse" aria-expanded="false" aria-controls="collapseExample" onclick="fileEntriesDropdown()">Files <i id="fileEntries" class="far fa-plus-square ml-2 float-right mr-5 mt-2"></i></h2>
                            <div class="collapse" id="fileCollapse">
                                <hr class="mt-0">
                                
                                <table class="mx-5" id="fileTable">
                                    <tr class="mb-3 pb-2 border-bottom">
                                        <th>File Title</th>
                                        <th class="textBody">File</th>
                                        <th class="rowInput">Remove Row</th>
                                    </tr>
                                    <tr class="mb-2 pb-3 border-bottom">
                                        <td><input type="text" class="form-control" placeholder="Insert File Title Here"></td>
                                        <td class="textBody"><input type="file" class="form-control"></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>

                                <div class="mx-5 py-2 mb-4">
                                    <input type="button" value="Add Another File" class="add btn btn-primary" onclick="addFile()">
                                </div>
                            </div>
                        </div>
                        <hr class="ml-4 mt-0">
                    </div>

                    <div class="form-group col-12 saveChanges">
                        <input type="submit" class="form-control btn btn-primary" value="Save Changes">
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script type="text/javascript">
        var isclick = true;
        function textEntriesDropdown(){
            if(isclick){
                isclick = false;
                    if ($('#textEntries').hasClass("far fa-plus-square")) {
                        $('#textEntries').removeClass("far fa-plus-square");
                        $('#textEntries').addClass("far fa-minus-square");
                        $('#textEntries').parent().css("color", "black");
                    } else{
                        $('#textEntries').removeClass("far fa-minus-square");
                        $('#textEntries').addClass("far fa-plus-square");
                        $('#textEntries').parent().removeAttr('style');
                    }                
                setTimeout(function(){
                    isclick = true;
                }, 350)
            }
        }

        var isclick2 = true;
        function urlEntriesDropdown(){
            if(isclick2){
                isclick2 = false;
                    if ($('#urlEntries').hasClass("far fa-plus-square")) {
                        $('#urlEntries').removeClass("far fa-plus-square");
                        $('#urlEntries').addClass("far fa-minus-square");
                        $('#urlEntries').parent().css("color", "black");
                    } else{
                        $('#urlEntries').removeClass("far fa-minus-square");
                        $('#urlEntries').addClass("far fa-plus-square");
                        $('#urlEntries').parent().removeAttr('style');
                    }                
                setTimeout(function(){
                    isclick2 = true;
                }, 350)
            }
        }

        var isclick3 = true;
        function fileEntriesDropdown(){
            if(isclick3){
                isclick3 = false;
                    if ($('#fileEntries').hasClass("far fa-plus-square")) {
                        $('#fileEntries').removeClass("far fa-plus-square");
                        $('#fileEntries').addClass("far fa-minus-square");
                        $('#fileEntries').parent().css("color", "black");
                    } else{
                        $('#fileEntries').removeClass("far fa-minus-square");
                        $('#fileEntries').addClass("far fa-plus-square");
                        $('#fileEntries').parent().removeAttr('style');
                    }                
                setTimeout(function(){
                    isclick3 = true;
                }, 350)
            }
        }
    </script>

    <script type="text/javascript">
        function remove(e) {
            e.parentElement.parentElement.remove();
        }

        function addText() {
            var start = $('#textTable'),
                newRow = $('<tr class="mb-2 pb-2 pt-2 border-bottom"><td><input type="text" class="form-control" placeholder="Insert Text Title Here"></td>' +
                        '<td class="textBody"><textarea name="textBody" placeholder="Insert Text Body Here" class="form-control"></textarea></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);
        }

        function addURL() {
            var start = $('#urlTable'),
                newRow = $('<tr class="mb-2 pb-3 pt-2 border-bottom"><td><input type="text" class="form-control" placeholder="Insert URL Description Here"></td>' +
                        '<td class="textBody"><input type="text" class="form-control" placeholder="Insert URL Here"></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);
        }

        function addFile() {
            var start = $('#fileTable'),
                newRow = $('<tr class="mb-2 pb-3 pt-2 border-bottom"><td><input type="text" class="form-control" placeholder="Insert File Title Here"></td>' +
                        '<td class="textBody"><input type="file" class="form-control"></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);
        }
    </script>
@endsection