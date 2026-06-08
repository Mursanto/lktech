<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasaWebsite;

class PageController extends Controller
{
    public function jasaWebsite()
    {
        $packages = JasaWebsite::where('is_active', true)->orderBy('harga_mulai', 'asc')->get();
        return view('pages.jasa-website', compact('packages'));
    }
}
