<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoVideoController extends Controller
{
    public function index()
    {
        $activeVideo = \App\Models\PromoVideo::where('is_active', true)->latest()->first();
        return view('admin.promo-video.index', compact('activeVideo'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required',
            'video' => 'required|mimes:mp4,webm|max:20480', // Maks 20MB
        ]);

        $path = $request->file('video')->store('promo_videos', 'public');

        // Nonaktifkan video lain jika hanya 1 yang aktif
        \App\Models\PromoVideo::where('is_active', true)->update(['is_active' => false]);

        \App\Models\PromoVideo::create([
            'title' => $request->title,
            'video_path' => $path,
            'target_url' => $request->target_url,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Video promo berhasil diunggah!');
    }
}
