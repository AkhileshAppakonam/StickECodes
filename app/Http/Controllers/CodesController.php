<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;

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

    public function show($id)
    {
        $code = Codes::find($id);
        return view('pages.editPage')->with('code', $code);
    }

    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'codeTitle' => 'required',
            'pageTitle' => 'required'
        ]);

        $code = Codes::find($id);
        $code->code_title = $request->input('codeTitle');
        $code->save();

        return redirect('/dashboard');
    }
}
