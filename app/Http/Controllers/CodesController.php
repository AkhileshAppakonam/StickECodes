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
        $user = User::find($authId);
        $code = $user->codes->where('id', $codeId)->first();
        // $code = Codes::where('id', $codeId)->where('user_id', $authId)->first();

        if (empty($code)) {
            abort(403, 'Unauthorized action.');
        } else{
            // $page = Pages::where('code_id', $codeId)->get()->first();
            // $securityProfiles = SecurityProfiles::select('id', 'profile_name')->where('user_id', $authId)->get();
            $page = $user->pages->where('code_id', $codeId)->first();
            $securityProfiles = $user->securityProfiles;
            return view('pages.editPage')->with(['code'=>$code, 'page'=>$page, 'securityProfiles'=>$securityProfiles]);
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
