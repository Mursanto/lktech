<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function jasaWebsite()
    {
        return view('pages.jasa-website');
    }
}
