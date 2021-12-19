@extends('layouts.app')

@section('content')
    <section id="publicQRCodePage">
        <div class="container">
            <header class="mb-5"><h1>This is the public page for: {{$codeName}}</h1></header>

            <div class="row px-3">
                <div class="form-group col-12 textEntries">
                    <h2>Text Entries</h2>

                    <table id="textEntries">
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Text</th>
                        </tr>

                        @if (count($pageTexts) > 0)
                            @foreach ($pageTexts as $pageText)
                                <tr>
                                    <td><p>{{$pageText -> created_at}}</p></td>
                                    <td><p>{{$pageText -> user -> name}}</p></td>
                                    <td><p>{{$pageText -> entry_description}}</p></td>
                                    <td><textarea class="px-2" disabled>{{$pageText -> entry_text}}</textarea></td>
                                </tr>
                            @endforeach
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

                        @if (count($pageUrls) > 0)
                            @foreach ($pageUrls as $pageUrl)
                                <tr>
                                    <td><p>{{$pageUrl -> created_at}}</p></td>
                                    <td><p>{{$pageUrl -> user -> name}}</p></td>
                                    <td><a class="pl-1" href="{{$pageUrl -> entry_url}}">{{$pageUrl -> entry_description}}</a></td>
                                </tr>
                            @endforeach
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

                        @if (count($pageFiles) > 0)
                            @foreach ($pageFiles as $pageFile)
                                <tr>
                                    <td><p>{{$pageFile -> created_at}}/p></td>
                                    <td><p>{{$pageFile -> user -> name}}</p></td>
                                    <td><a class="pl-1" href="/public/index.php/viewPagesFile/{{$pageFile -> entry_description}}/{{$pageFile -> file}}/{{$pageFile -> entry_date}}">{{$pageFile -> entry_description}}</a></td>
                                </tr>
                            @endforeach
                        @endif

                        
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection