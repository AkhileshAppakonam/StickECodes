<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;
use App\Pages;

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
        $code = Codes::where('id', $codeId)->where('user_id', $authId)->first();

        if (empty($code)) {
            abort(403, 'Unauthorized action.');
        } else{
            $page = Pages::where('code_id', $codeId)->get()->first();
            return view('pages.editPage')->with(['code'=>$code, 'page'=>$page]);
        }
    }

    public function edit(Request $request, $codeId, $pageId)
    {
        $this->validate($request, [
            'codeTitle' => 'required',
            'pageTitle' => 'required'
        ]);

        $code = Codes::find($codeId);
        $code->code_title = $request->input('codeTitle');
        $code->save();

        $page = Pages::find($pageId);
        $page->page_title = $request->input('pageTitle');
        $page->save();

        return redirect('/dashboard')->with('success', $code->code_name.': Code Updated Successfully');
    }
}
