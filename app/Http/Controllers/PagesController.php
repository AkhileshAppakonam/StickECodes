<?php

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

class PagesController extends Controller
{

    public function welcome()
    {
        return view('pages.welcome');
    }

    public function index()
    {
        $title = 'Welcome to Laravel!!!';
        // return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about()
    {
        $title = 'About Us!!!';
        return view('pages.about')->with('title', $title);
    }

    public function services()
    {
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO'] 
        );
        return view('pages.services')->with($data);
    }

    public function codeLookUpView()
    {
        return view('pages.codeLookUp');
    }

    public function create(Codes $code)
    {
        $page = new Pages;
        $page->created_at = NOW();
        $page->updated_at = NOW();
        $page->code_id = $code->id;
        $page->security_profile_id = NULL;
        $page->page_title = "Unset Page Title Description";
        $page->save();

        return redirect('/codes/'.$code->id.'/editPage')->with('success', $code->code_name.': New Page Created Successfully');
    }
}
