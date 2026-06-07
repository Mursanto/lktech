<?php

namespace App\Http\Controllers;

use App\Models\RakitPcPackage;
use Illuminate\Http\Request;

class PublicRakitPcController extends Controller
{
    public function index()
    {
        $packages = RakitPcPackage::where('is_active', true)->orderBy('created_at', 'desc')->get();
        return view('pages.rakit-pc', compact('packages'));
    }
}
