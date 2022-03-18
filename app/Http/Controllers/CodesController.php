<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\Codes;
use App\Pages;
use App\SecurityProfiles;
use App\SecurityProfilesUsers;
use App\User;
use App\PageFiles;
use App\PageUrls;
use App\PageTexts;

// For Generating QR Codes
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require_once('./../vendor/autoload.php');

class CodesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() 
    {
        $this->authorize('createQRCode', Codes::class);

        $options = new QROptions([
            'eccLevel' => QRCode::ECC_L,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'version' => 5,
        ]);

        // Generate Random 5 byte String for Code Name
        $length = 5;
        $randomBytes = openssl_random_pseudo_bytes($length);
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $codeName = '';

        for ($i = 0; $i < $length; $i++) {
            $codeName .= $characters[ord($randomBytes[$i]) % $charactersLength];
        }


        $authName = auth()->user()->name;
        $authId = auth()->user()->id;

        $authName = str_replace(' ', '', $authName);

        $key = $authName."/".$codeName;

        $code = new Codes;
        $code->created_at = NOW();
        $code->updated_at = NOW();
        $code->code_name = $codeName;
        $code->user_id = $authId;
        $code->code_title = "Unnamed Code: ".$codeName;
        $code->geo_location = 0;
        $code->location = NULL;
        $code->save();

        $page = new Pages;
        $page->created_at = NOW();
        $page->updated_at = NOW();
        $page->code_id = $code->id;
        $page->security_profile_id = NULL;
        $page->page_title = "Unset Page Title Description";
        $page->save();


        $qrcode = (new QRCode($options))->render('http://54.176.144.89/public/index.php/pages/'.$key);

        $file = fopen(resource_path('views/QRCodePages/'.$authName.$codeName.'.blade.php' ), 'w' ) or die("Unable to Create Page!");
        $txt = "@include('inc.templateQRCodePage')";
        file_put_contents(resource_path('views/QRCodePages/'.$authName.$codeName.'.blade.php' ), $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
        fclose($file);

        file_put_contents('/var/www/html/resources/views/QRCodeImageData/'.$codeName.'.png', $qrcode);

        return redirect('/dashboard')->with('success', $codeName.': Code Created Successfully');
    }

    public function showPublicQRCodePage($userName, $codeName)
    {
        $userName = str_replace(' ', '', $userName);

        $code = Codes::where('code_name', $codeName)->get()->first();
        
        try {
            return view('QRCodePages.'.$userName.$codeName)->with('code', $code);
        } catch (\Throwable $th) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function showEditPage(Codes $code)
    {
        if (!(Gate::allows('editPage', $code) || Gate::allows('viewAndUpdate', $code))) {
            abort(403, 'Unauthorized action.');
        }

        $securityProfiles = $code->user->securityProfiles;

        // echo $code->pages;
        // echo "<br>";
        // echo "<br>";

        // foreach ($code->pages as $page) {
        //     echo $page->page_files;
        //     echo "<br>";
        //     echo $page->page_urls;
        //     echo "<br>";
        //     echo $page->page_texts;
        //     echo "<br>";

        //     foreach ($page->page_texts as $pageText) {
        //         echo $pageText;
        //         echo "<br>";
        //     }
        // }

        // echo "<br>";
        // echo "<br>";

        $pageFiles = Pages::with('page_files')->where('code_id', $code->id)->get();
        $pageURLs = Pages::with('page_urls')->where('code_id', $code->id)->get();
        $pageTexts = Pages::with('page_texts')->where('code_id', $code->id)->get();

        return view('pages.editPage')->with(['code'=>$code, 'securityProfiles'=>$securityProfiles, 'pageFiles'=>$pageFiles, 'pageURLs'=>$pageURLs, 'pageTexts'=>$pageTexts]);
    }

    public function edit(Request $request, Codes $code, $pageId)
    {
        if (!(Gate::allows('editPage', $code) || Gate::allows('viewAndUpdate', $code))) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'codeTitle' => 'required',
            'pageTitle' => 'required',
            'securityProfile' => 'required',
            // Check Files
            'fileCount' => 'required',
            'DBFileCount' => 'required',
            'DBFileCountRemaining' => 'required',
            // Check URLs
            'urlCount' => 'required',
            'DBURLCount' => 'required',
            'DBURLCountRemaining' => 'required',
            // Check Texts
            'textCount' => 'required',
            'DBTextCount' => 'required',
            'DBTextCountRemaining' => 'required'
        ]);

        // Handling Texts Section

            // Dealting with Text Entries
            $textCount = $request->input('textCount');
            $DBTextCount = $request->input('DBTextCount');
            $DBTextCountRemaining = $request->input('DBTextCountRemaining');

            for ($k=0; $k <= $textCount-$DBTextCountRemaining; $k++) { 
                if ($request->filled('userTextTitle'.$k) || $request->filled('userText'.$k)) {
                    $request->validate([
                        'userTextTitle'.$k => 'required',
                        'userText'.$k => 'required'
                    ],
                    [
                        'userTextTitle'.$k.'.required' => 'A Text Title is Required on Row '.($k+$DBTextCountRemaining+1),
                        'userText'.$k.'.required' => 'A Text Description is Required on Row '.($k+$DBTextCountRemaining+1)
                    ]);

                    $pageText = new PageTexts;
                    $pageText->page_id = $pageId;
                    $pageText->user_id = auth()->user()->id;
                    $pageText->entry_date = NOW();
                    $pageText->entry_description = $request->input('userTextTitle'.$k);
                    $pageText->entry_text = $request->input('userText'.$k);
                    $pageText->save();
                }
            }

            // Updating Existing Text Entries
            for ($k=0; $k <= $DBTextCount-1; $k++) { 
                if ($request->filled('userTextTitleUpdate'.$k) || $request->filled('userTextUpdate'.$k)) {
                    $request->validate([
                        'userTextTitleUpdate'.$k => 'required',
                        'userTextUpdate'.$k => 'required',
                        'userTextId'.$k => 'required'
                    ],
                    [
                        'userTextTitleUpdate'.$k.'.required' => 'A Text Title is Required on Row '.($k+1),
                        'userTextUpdate'.$k.'.required' => 'A Text Description is Required on Row '.($k+1)
                    ]);

                    $pageText = PageTexts::find($request->input('userTextId'.$k));
                    $pageText->entry_description = $request->input('userTextTitleUpdate'.$k);
                    $pageText->entry_text = $request->input('userTextUpdate'.$k);
                    $pageText->save();
                } else{
                    $pageTextDelete = PageTexts::find($request->input('userTextId'.$k))->delete();
                }
            }

        // End Texts Section

        // Handling URLs Section

            // Dealing with URL Entries
            $urlCount = $request->input('urlCount');
            $DBURLCount = $request->input('DBURLCount');
            $DBURLCountRemaining = $request->input('DBURLCountRemaining');

            for ($j=0; $j <= $urlCount-$DBURLCountRemaining ; $j++) { 
                if ($request->filled('userURLTitle'.$j) || $request->filled('userURL'.$j)) {
                    $request->validate([
                        'userURLTitle'.$j => 'required',
                        'userURL'.$j => 'required|url'
                    ], 
                    [
                        'userURLTitle'.$j.'.required' => 'A URL Description is Required on Row '.($j+$DBURLCountRemaining+1),
                        'userURL'.$j.'.required' => 'A URL is Required on Row '.($j+$DBURLCountRemaining+1),
                        'userURL'.$j.'.url' => 'Invalid URL Format on Row '.($j+$DBURLCountRemaining+1)
                    ]);

                    $pageURL = new PageUrls;
                    $pageURL->page_id = $pageId;
                    $pageURL->user_id = auth()->user()->id;
                    $pageURL->entry_date = NOW();
                    $pageURL->entry_description = $request->input('userURLTitle'.$j);
                    $pageURL->entry_url = $request->input('userURL'.$j);
                    $pageURL->save();
                }
            }

            // Updating Existing URLs
            for ($j=0; $j <= $DBURLCount-1; $j++) { 
                if ($request->filled('userURLTitleUpdate'.$j) || $request->filled('userURLUpdate'.$j)) {
                    $request->validate([
                        'userURLTitleUpdate'.$j => 'required',
                        'userURLUpdate'.$j => 'required|url',
                        'userURLId'.$j => 'required'
                    ], 
                    [
                        'userURLTitleUpdate'.$j.'.required' => 'A URL Description is Required on Row '.($j+1),
                        'userURLUpdate'.$j.'.required' => 'A URL is Required on Row '.($j+1),
                        'userURLUpdate'.$j.'.url' => 'Invalid URL Format on Row '.($j+1)
                    ]);

                    $pageURL = PageUrls::find($request->input('userURLId'.$j));
                    $pageURL->entry_description = $request->input('userURLTitleUpdate'.$j);
                    $pageURL->entry_url = $request->input('userURLUpdate'.$j);
                    $pageURL->save();
                } else {
                    $pageURLDelete = PageUrls::find($request->input('userURLId'.$j))->delete();
                }
                
            }

        // End URL Section

        // Handling Files Section

            // Dealing with File Entries
            $fileCount = $request->input('fileCount');
            $DBFileCount = $request->input('DBFileCount');
            $DBFileCountRemaining = $request->input('DBFileCountRemaining');

            // echo $request->input('codeTitle');
            // echo "<br>";
            // echo $request->input('securityProfile');
            // echo "<br>";
            // echo $request->input('pageTitle');
            // echo "<br>";
            // echo $fileCount;
            // echo "<br>";
            // echo $DBFileCount;
            // echo "<br>";

            for ($i=0; $i <= $fileCount-$DBFileCountRemaining; $i++) { 
                if ($request->filled('userFilesTitle'.$i) || $request->has('userFiles'.$i)) {
                    $request->validate([
                        'userFilesTitle'.$i => 'required',
                        'userFiles'.$i => 'mimes:jpeg,jpg,bmp,png,pdf,gif,svg|required|max:1999'
                    ],
                    [
                        'userFilesTitle'.$i.'.required' => 'A File Title is Required on Row '.($i+$DBFileCountRemaining+1),
                        'userFiles'.$i.'.required' => 'Please Select a File on Row '.($i+$DBFileCountRemaining+1),
                        'userFiles'.$i.'.mimes' => 'The File on Row '.($i+$DBFileCountRemaining+1).' failed to upload. Please ensure the file is one of the following file types: jpeg, jpg, bmp, png, pdf, gif, svg',
                        'userFiles'.$i.'.max' => 'The File on Row '.($i+$DBFileCountRemaining+1).' failed to upload. Please ensure the size of the file does not exceed 1999 Kilobytes',
                        'userFiles'.$i.'.uploaded' => 'The File on Row '.($i+$DBFileCountRemaining+1).' failed to upload. Please ensure the size of the file does not exceed 1999 Kilobytes and is one of the following file types: jpeg, jpg, bmp, png, pdf, gif, svg'
                    ]);

                    // Get File name with extension
                    $fileNameWithExt = $request->file('userFiles'.$i)->getClientOriginalName();
                    // Get just File name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $request->file('userFiles'.$i)->getClientOriginalExtension();
                    // File name to store
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    // Upload Image
                    $path = $request->file('userFiles'.$i)->storeAs('public/user_files', $fileNameToStore);

                    $pageFile = new PageFiles;
                    $pageFile->page_id = $pageId;
                    $pageFile->user_id = auth()->user()->id;
                    $pageFile->entry_date = NOW();
                    $pageFile->entry_description = $request->input('userFilesTitle'.$i);
                    $pageFile->file = $fileNameToStore;
                    $pageFile->file_type = $extension;
                    $pageFile->save();
                }
            }

            // Updating Existing Files
            for ($i=0; $i <= $DBFileCount-1; $i++) { 
                if ($request->filled('userFilesUpdate'.$i)) {
                    $request->validate([
                        'userFilesTitleUpdate'.$i => 'required',
                        'userFilesUpdate'.$i => 'required',
                        'userFilesId'.$i => 'required'
                    ],
                    [
                        'userFilesTitleUpdate'.$i.'.required' => 'A File Title is Required on Row '.($i+1)
                    ]);

                    $pageFile = PageFiles::find($request->input('userFilesId'.$i));
                    $pageFile->entry_description = $request->input('userFilesTitleUpdate'.$i);
                    $pageFile->save();
                } else {
                    $pageFileDelete = PageFiles::find($request->input('userFilesId'.$i))->delete();
                }
            }

        // End Files Section

        // Saving General Code Information
        $code->code_title = $request->input('codeTitle');
        $code->save();

        $page = Pages::find($pageId);
        $page->security_profile_id = $request->input('securityProfile');
        $page->page_title = $request->input('pageTitle');
        $page->save();

        if (Gate::allows('editPage', $code)) {
            return redirect('/dashboard')->with('success', $code->code_name.': Code Updated Successfully');
        } elseif (Gate::allows('viewAndUpdate', $code)) {
            return redirect('/pages/'.$code -> user -> name.'/'.$code -> code_name)->with('success', $code->code_name.': Code Updated Successfully');
        }
    }

    public function viewFile(PageFiles $file)
    {  
        return view('pages.viewFile')->with('file', $file);
    }

    public function codeLookUp(Request $request)
    {
        $validated = $request->validate([
            'codeName' => 'required'
        ]);

        try {
            $userName = Codes::where('code_name', $request->input('codeName'))->get()->first()->user->name;

            return $this->showPublicQRCodePage($userName, $request->input('codeName'));
        } catch (\Throwable $th) {
            return redirect('/codes/lookUp')->with('error', $request->input('codeName').': This code does not exist');
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'delete' => 'required'
        ]);

        $authName = auth()->user()->name;
        $authName = str_replace(' ', '', $authName);

        $code = Codes::find($request->input('delete'));
        $codeName = $code->code_name;

        // Code Deletion and all its contents
        foreach ($code->pages as $page) {
            foreach ($page->page_texts as $pageTexts) {
                $pageTexts->delete();
            }

            foreach ($page->page_urls as $pageUrls) {
                $pageUrls->delete();
            }

            foreach ($page->page_files as $pageFiles) {
                $pageFiles->delete();
            }

            $page->delete();
        }

        $code->delete();

        // File Deletion within Server
        if(\File::exists(resource_path('views/QRCodePages/'.$authName.$codeName.'.blade.php'))){
            echo $authName.$codeName;
            \File::delete(resource_path('views/QRCodePages/'.$authName.$codeName.'.blade.php'));
        }

        if(\File::exists(resource_path('views/QRCodeImageData/'.$codeName.'.png'))){
            echo $codeName;
            \File::delete(resource_path('views/QRCodeImageData/'.$codeName.'.png'));
        }

        return redirect('/dashboard')->with('success', $codeName.': Code Deleted Successfully');
    }
}
