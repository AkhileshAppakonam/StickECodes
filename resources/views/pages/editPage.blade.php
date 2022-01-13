@extends('layouts.app')

@section('content')
    <section id="editPage">
        <form id="editPageForm" name="editPageForm" enctype="multipart/form-data" action="/public/index.php/codes/{{$code -> id}}/{{$code -> pages[0] -> id}}/editPage" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>{{$code -> code_name ." ". $code -> code_title}}</h1></header>

                @include('inc.messages')

                <div class="row shadow p-3 mb-5 bg-white rounded">
                    <div class="col-md-4 code">
                        <figure class="mb-0">
                            <div class="image"><a href="/public/index.php/pages/{{$code -> user -> name}}/{{$code -> code_name}}"><img src="{{file_get_contents('/var/www/html/resources/views/QRCodeImageData/'.$code -> code_name.'.png')}}" alt='QR Code' width='300' height='300'></a></div>
                        </figure>
                    </div>
                    <div class="col-md-8 codeProperties">
                        <div class="container"> 
                            <div class="form-group row">
                                <label for="codeTitle" class="col-md-0 col-form-label text-md-right">Code Title</label>
                                <input id="codeTitle" name="codeTitle" type="text" class="form-control" placeholder="Insert Code Title Here" value="{{$code -> code_title}}" @canany(['fullControl', 'editPage'], $code) @elsecanany(['viewAndUpdate'], $code) {{"disabled"}} @endcanany required>
                            </div>
                            <div class="form-group row">
                                <label for="pageTitle" class="col-md-0 col-form-label text-md-right">Page Title</label>
                                <input id="pageTitle" name="pageTitle" type="text" class="form-control" placeholder="Insert Title Description for Public Page Here" value="{{$code -> pages[0] -> page_title}}" @canany(['fullControl', 'editPage'], $code) @elsecanany(['viewAndUpdate'], $code) {{"disabled"}} @endcanany required>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="container p-0 ml-0">
                                    <label for="chooseSP" class="col-md-0 col-form-label text-md-right">Select a Security Profile</label>
                                    <select id="chooseSP" name="securityProfile" class="form-control" @canany(['fullControl', 'editPage'], $code) @elsecanany(['viewAndUpdate'], $code) {{"disabled"}} @endcanany>

                                        @if (count($securityProfiles) > 0)
                                            @foreach ($securityProfiles as $securityProfile)
                                                <option value="{{$securityProfile -> id}}"
                                                    @if (($code -> pages[0] -> security_profile_id) === ($securityProfile -> id))
                                                        {{"selected"}}
                                                    @endif
                                                >{{$securityProfile -> profile_name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Security Profiles</option>
                                        @endif

                                    </select>
                                </div>
                                <div class="or">
                                    <p class="p-0">OR</p>
                                </div>
                                <div class="container p-0 mr-0 makeSP">
                                    <a href="/public/index.php/securityProfilePage/create/{{$code->id}}" class="btn btn-primary @canany(['fullControl', 'editPage'], $code) @elsecanany(['viewAndUpdate'], $code) {{"disabled"}} @endcanany">Make a New Security Profile</a>
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

                                    @if (count($pageTexts) > 0)
                                        @foreach ($pageTexts as $page)

                                            <input type="hidden" id="DBTextCount" name="DBTextCount" class="form-control" value="{{count($page->page_texts)}}">
                                            <input type="hidden" id="DBTextCountRemaining" name="DBTextCountRemaining" class="form-control" value="{{count($page->page_texts)}}">

                                            @for ($k = 0; $k < count($page->page_texts); $k++)
                                                <tr class="mb-2 pb-3 pt-2 border-bottom">
                                                    <td><input type="text" class="form-control" name="userTextTitleUpdate{{$k}}" value="{{$page->page_texts[$k] -> entry_description}}"></td>
                                                    <td class="textBody"><textarea name="userTextUpdate{{$k}}" placeholder="Insert Text Body Here" class="form-control">{{$page->page_texts[$k] -> entry_text}}</textarea></td>
                                                    <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark hasText" onclick="remove(this)"></td>
                                                </tr>
                                                {{-- This input has to be outside tr because remove btn removes tr and therefore any input within it --}}
                                                <input type="hidden" class="form-control" name="userTextId{{$k}}" value="{{$page->page_texts[$k]->id}}">
                                            @endfor

                                        @endforeach
                                    @endif

                                    <tr class="mb-2 pb-2 pt-2 border-bottom">
                                        <td><input type="text" class="form-control" name="userTextTitle0" placeholder="Insert Text Title Here"></td>
                                        <td class="textBody"><textarea name="userText0" placeholder="Insert Text Body Here" class="form-control"></textarea></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>

                                <input type="hidden" id="textCount" name="textCount" class="form-control">

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

                                    @if (count($pageURLs) > 0)
                                        @foreach ($pageURLs as $page)

                                            <input type="hidden" id="DBURLCount" name="DBURLCount" class="form-control" value="{{count($page->page_urls)}}">
                                            <input type="hidden" id="DBURLCountRemaining" name="DBURLCountRemaining" class="form-control" value="{{count($page->page_urls)}}">

                                            @for ($j = 0; $j < count($page->page_urls); $j++)
                                                <tr class="mb-2 pb-3 pt-2 border-bottom">
                                                    <td><input type="text" class="form-control" name="userURLTitleUpdate{{$j}}" value="{{$page->page_urls[$j] -> entry_description}}"></td>
                                                    <td class="textBody"><input type="text" class="form-control" name="userURLUpdate{{$j}}" value="{{$page->page_urls[$j] -> entry_url}}"></td>
                                                    <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark hasURL" onclick="remove(this)"></td>
                                                </tr>
                                                {{-- This input has to be outside tr because remove btn removes tr and therefore any input within it --}}
                                                <input type="hidden" class="form-control" name="userURLId{{$j}}" value="{{$page->page_urls[$j]->id}}">
                                            @endfor
                                        @endforeach
                                    @endif

                                    <tr class="mb-2 pb-3 pt-2 border-bottom">
                                        <td><input type="text" class="form-control" name="userURLTitle0" placeholder="Insert URL Description Here"></td>
                                        <td class="textBody"><input type="text" name="userURL0" class="form-control" placeholder="Insert URL Here"></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>

                                <input type="hidden" id="urlCount" name="urlCount" class="form-control">

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

                                    @if (count($pageFiles) > 0)
                                        @foreach ($pageFiles as $page)

                                            <input type="hidden" id="DBFileCount" name="DBFileCount" class="form-control" value="{{count($page->page_files)}}">
                                            <input type="hidden" id="DBFileCountRemaining" name="DBFileCountRemaining" class="form-control" value="{{count($page->page_files)}}">

                                            @for ($i = 0; $i < count($page->page_files); $i++)
                                                <tr class="mb-2 pb-3 pt-2 border-bottom">
                                                    <td><input type="text" class="form-control" name="userFilesTitleUpdate{{$i}}" value="{{$page->page_files[$i] -> entry_description}}"></td>
                                                    <td class="textBody">
                                                        <a href="/public/index.php/viewPagesFile/{{$page->page_files[$i] -> id}}" class="pl-3">{{$page->page_files[$i]->file}}</a>
                                                        <input type="hidden" class="form-control" name="userFilesUpdate{{$i}}" value="{{$page->page_files[$i]->file}}">
                                                    </td>
                                                    <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark hasFile" onclick="remove(this)"></td>
                                                </tr>
                                                {{-- This input has to be outside tr because remove btn removes tr and therefore any input within it --}}
                                                <input type="hidden" class="form-control" name="userFilesId{{$i}}" value="{{$page->page_files[$i]->id}}">
                                            @endfor
                                        @endforeach
                                    @endif

                                    <tr class="mb-2 pb-3 pt-2 border-bottom">
                                        <td><input type="text" class="form-control" name="userFilesTitle0" placeholder="Insert File Title Here"></td>
                                        <td class="textBody"><input type="file" name="userFiles0" class="form-control" accept=".jpeg,.jpg,.bmp,.png,.pdf,.gif,.svg"></td>
                                        <td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                                    </tr>
                                </table>


                                <input type="hidden" id="fileCount" name="fileCount" class="form-control">

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

            if (e.classList.contains('hasFile')) {
                var DBpageFileCountRemaining = document.getElementById('DBFileCountRemaining');

                DBpageFileCountRemaining.value = DBpageFileCountRemaining.value-1;
            }

            if (e.classList.contains('hasURL')) {
                var DBpageURLCountRemaining = document.getElementById('DBURLCountRemaining');

                DBpageURLCountRemaining.value = DBpageURLCountRemaining.value-1;
            }

            if (e.classList.contains('hasText')) {
                var DBpageTextCountRemaining = document.getElementById('DBTextCountRemaining');

                DBpageTextCountRemaining.value = DBpageTextCountRemaining.value-1;
            }

            e.parentElement.parentElement.remove();

            fileCount();
            urlCount();
            textCount();
        }

        z = 1;
        function addText() {
            var start = $('#textTable'),
                newRow = $('<tr class="mb-2 pb-2 pt-2 border-bottom"><td><input type="text" name="userTextTitle'+z+'" class="form-control" placeholder="Insert Text Title Here"></td>' +
                        '<td class="textBody"><textarea name="userText'+z+'" placeholder="Insert Text Body Here" class="form-control"></textarea></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);

            textCount();
            z++;
        }

        var y = 1;
        function addURL() {
            var start = $('#urlTable'),
                newRow = $('<tr class="mb-2 pb-3 pt-2 border-bottom"><td><input type="text" name="userURLTitle'+y+'" class="form-control" placeholder="Insert URL Description Here"></td>' +
                        '<td class="textBody"><input type="text" name="userURL'+y+'" class="form-control" placeholder="Insert URL Here"></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);

            urlCount();
            y++;
        }

        var x = 1;
        function addFile() {
            var start = $('#fileTable'),
                newRow = $('<tr class="mb-2 pb-3 pt-2 border-bottom"><td><input type="text" name="userFilesTitle'+x+'" class="form-control" placeholder="Insert File Title Here"></td>' +
                        '<td class="textBody"><input type="file" name="userFiles'+x+'" class="form-control"></td>' +
                        '<td class="rowInput"><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);

            fileCount();
            x++;
        }
    </script>

    <script type="text/javascript">
        function fileCount() {
            var fileCount = document.getElementById('fileCount');
            var fileTableRowCount = document.getElementById('fileTable').rows.length;

            fileCount.value = fileTableRowCount-2;
        }

        function urlCount() {
            var urlCount = document.getElementById('urlCount');
            var urlTableRowCount = document.getElementById('urlTable').rows.length;

            urlCount.value = urlTableRowCount-2;
        }

        function textCount() {
            var textCount = document.getElementById('textCount');
            var textTableRowCount = document.getElementById('textTable').rows.length;

            textCount.value = textTableRowCount-2;
        }
    </script>


    <script>
        window.onload = function() {
            fileCount();
            urlCount();
            textCount();
        }
    </script>
@endsection