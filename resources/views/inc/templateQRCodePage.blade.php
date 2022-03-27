@extends('layouts.app')

@section('content')
    <section id="publicQRCodePage">
        <div class="container">
            <header class="mb-1">
                <h1>This is the public page for: {{$code -> code_name}}</h1>
                @canany(['masterUser', 'editCode'], $code)
                    <a href="/public/index.php/codes/{{$code -> id}}/editPage" class="btn btn-primary">Edit Page</a>
                @endcanany
            </header>

            @include('inc.messages')

            <div class="row px-3">
                @foreach ($code->pages as $key => $page)
                    @canany(['publicAccess', 'viewOnly', 'viewAndUpdate', 'fullControl', 'masterUserPage'], $page)
                        <header class="pt-5 pb-3"><h1>Page {{$key+1}}: </h1></header>

                        <div class="form-group col-12 textEntries">
                            <h2>Text Entries</h2>

                            <table id="textEntries">
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>Text</th>
                                </tr>

                                @if (count($page->page_texts) > 0)
                                    @foreach ($page->page_texts as $pageText)
                                        <tr>
                                            <td><p>{{$pageText -> created_at}}</p></td>
                                            <td><p>{{$pageText->user -> name}}</p></td>
                                            <td><p>{{$pageText -> entry_description}}</p></td>
                                            <td><textarea class="px-2" disabled>{{$pageText -> entry_text}}</textarea></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="noContents">
                                        <td><p>No Texts</p></td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="form-group col-12 urlEntries">
                            <h2>URLs</h2>

                            <table class="mb-2" id="urlEntries">
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                </tr>

                                @if (count($page->page_urls) > 0)
                                    @foreach ($page->page_urls as $pageUrl)
                                        <tr>
                                            <td><p>{{$pageUrl -> created_at}}</p></td>
                                            <td><p>{{$pageUrl->user -> name}}</p></td>
                                            <td><a class="pl-1" href="{{$pageUrl -> entry_url}}">{{$pageUrl -> entry_description}}</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="noContents">
                                        <td><p>No Urls</p></td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="form-group col-12 fileEntries">
                            <h2>File Entries</h2>

                            <table id="fileEntries">
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                </tr>

                                @if (count($page->page_files) > 0)
                                    @foreach ($page->page_files as $pageFile)
                                        <tr>
                                            <td><p>{{$pageFile -> created_at}}</p></td>
                                            <td><p>{{$pageFile->user -> name}}</p></td>
                                            <td><a class="pl-1" href="/public/index.php/viewPagesFile/{{$pageFile -> id}}">{{$pageFile -> entry_description}}</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="noContents">
                                        <td><p>No Files</p></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    @elsecanany(['privateAccess'], $page)
                        
                    @endcanany
                @endforeach
            </div>
        </div>
    </section>
@endsection