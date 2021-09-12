<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;
use App\Pages;
use App\SecurityProfiles;
use App\User;
use App\PageFiles;

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

    public function show($codeId)
    {
        $authId = auth()->user()->id;
        $codes = Codes::with('pages')->find($codeId);
        $securityProfiles = User::find($authId)->securityProfiles;
        $pageFiles = Pages::with('page_files')->where('code_id', $codeId)->get();

        if (empty($codes) || ($codes->user->id !== $authId)) {
            abort(403, 'Unauthorized action.');
        } else{
            
            // echo $codes;
            // echo "<br>";
            // echo "<br>";
            // echo $securityProfiles;
            // echo "<br>";
            // echo "<br>";
            // echo $pageFiles;
            // echo "<br>";
            // echo "<br>";
            
            // foreach ($pageFiles as $page) {
            //     echo "<br>";
            //     echo $page->page_files;
            //     echo "<br>";

            //     foreach ($page->page_files as $page_file) {
            //         echo "<br>";
            //         echo $page_file->entry_description;
            //         echo "<br>";
            //         echo $page_file->file;
            //         echo "<br>";
            //         echo "<br>";
            //     }
            // }

            // echo "<br>";
            // echo "<br>";
            // echo "<br>";
            // echo "<br>";

            // foreach ($pageFiles as $page) {
            //     echo "<br>";
            //     echo $page->page_files;
            //     echo "<br>";
            //     echo count($page->page_files);

            //     for ($j=0; $j < count($page->page_files); $j++) { 
            //         echo "<br>";
            //         echo $page->page_files[$j]->file;
            //         echo "<br>";
            //     }
            // }

            return view('pages.editPage')->with(['code'=>$codes, 'securityProfiles'=>$securityProfiles, 'pageFiles'=>$pageFiles]);
        }
    }

    public function edit(Request $request, $codeId, $pageId)
    {
        $validated = $request->validate([
            'codeTitle' => 'required',
            'pageTitle' => 'required',
            'securityProfile' => 'required',
            'fileCount' => 'required',
            'DBFileCount' => 'required',
            'DBFileCountRemaining' => 'required'
        ]);

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
                    'userFilesTitle'.$i.'.required' => 'A File Title is Required on Row '.($i+$DBFileCount+1),
                    'userFiles'.$i.'.required' => 'Please Select a File on Row '.($i+$DBFileCount+1),
                    'userFiles'.$i.'.mimes' => 'The File on Row '.($i+$DBFileCount+1).' failed to upload. Please ensure the file is one of the following file types: jpeg, jpg, bmp, png, pdf, gif, svg',
                    'userFiles'.$i.'.max' => 'The File on Row '.($i+$DBFileCount+1).' failed to upload. Please ensure the size of the file does not exceed 1999 Kilobytes',
                    'userFiles'.$i.'.uploaded' => 'The File on Row '.($i+$DBFileCount+1).' failed to upload. Please ensure the size of the file does not exceed 1999 Kilobytes and is one of the following file types: jpeg, jpg, bmp, png, pdf, gif, svg'
                ]);

                // Get File name with extension
                $fileNameWithExt = $request->file('userFiles'.$i)->getClientOriginalName();
                // Get just File name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('userFiles'.$i)->getClientOriginalExtension();
                // File name to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                // // Upload Image
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

        $code = Codes::find($codeId);
        $code->code_title = $request->input('codeTitle');
        $code->save();

        $page = Pages::find($pageId);
        $page->security_profile_id = $request->input('securityProfile');
        $page->page_title = $request->input('pageTitle');
        $page->save();

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

        return redirect('/dashboard')->with('success', $code->code_name.': Code Updated Successfully');
    }

    public function viewFile($fileName, $file, $entryDate)
    {  
        return view('pages.viewFile')->with(['fileName'=>$fileName, 'file'=>$file, 'entryDate'=>$entryDate]);
    }
}
