<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasaWebsite;
use App\Models\WifiVoucher;

class PageController extends Controller
{
    public function jasaWebsite()
    {
        $packages = JasaWebsite::where('is_active', true)->orderBy('harga_mulai', 'asc')->get();
        return view('pages.jasa-website', compact('packages'));
    }

    public function wifiVoucher()
    {
        $packages = WifiVoucher::where('is_active', true)->orderBy('harga', 'asc')->get();
        return view('pages.wifi-voucher', compact('packages'));
    }
}
