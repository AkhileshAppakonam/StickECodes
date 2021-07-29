<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;
use App\Pages;
use App\SecurityProfiles;
use App\User;

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

        if (empty($codes) || ($codes->user->id !== $authId)) {
            abort(403, 'Unauthorized action.');
        } else{
            
            // echo $codes;
            // echo "<br>";
            // echo "<br>";
            // echo $securityProfiles;
            // echo "<br>";
            // echo "<br>";

            return view('pages.editPage')->with(['code'=>$codes, 'securityProfiles'=>$securityProfiles]);
        }
    }

    public function edit(Request $request, $codeId, $pageId)
    {
        $validated = $request->validate([
            'codeTitle' => 'required',
            'pageTitle' => 'required',
            'securityProfile' => 'required'
        ]);

        $code = Codes::find($codeId);
        $code->code_title = $request->input('codeTitle');
        $code->save();

        $page = Pages::find($pageId);
        $page->security_profile_id = $request->input('securityProfile');
        $page->page_title = $request->input('pageTitle');
        $page->save();

        return redirect('/dashboard')->with('success', $code->code_name.': Code Updated Successfully');
    }
}
