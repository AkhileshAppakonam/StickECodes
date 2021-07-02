<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;

class CodesController extends Controller
{
    public function show($id)
    {
        $code = Codes::find($id);
        return view('pages.editPage')->with('code', $code);
    }
}
