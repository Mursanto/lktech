<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoVideoController extends Controller
{
    public function index()
    {
        $videos = PromoVideo::latest()->get();
        return view('admin.promo-video.index', compact('videos'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required',
            'video' => 'required|mimes:mp4,webm|max:20480', // Maks 20MB
        ]);

        $path = $request->file('video')->store('promo_videos', 'public');

        // Nonaktifkan video lain jika hanya 1 yang aktif
        PromoVideo::where('is_active', true)->update(['is_active' => false]);

        PromoVideo::create([
            'title' => $request->title,
            'video_path' => $path,
            'target_url' => $request->target_url,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Video promo berhasil diunggah!');
    }

    public function update(Request $request, PromoVideo $promoVideo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_url' => 'nullable|url',
            'video' => 'nullable|mimes:mp4,webm|max:20480', // video opsional saat edit
        ]);

        $data = [
            'title' => $request->title,
            'target_url' => $request->target_url,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        // Jika user memilih file video baru, hapus video lama dan simpan video baru
        if ($request->hasFile('video')) {
            if ($promoVideo->video_path && Storage::disk('public')->exists($promoVideo->video_path)) {
                Storage::disk('public')->delete($promoVideo->video_path);
            }
            $data['video_path'] = $request->file('video')->store('promo_videos', 'public');
        }

        // Jika video ini diset Aktif, nonaktifkan video lainnya
        if ($data['is_active']) {
            PromoVideo::where('id', '!=', $promoVideo->id)->update(['is_active' => false]);
        }

        $promoVideo->update($data);

        return redirect()->back()->with('success', 'Video promo berhasil diperbarui!');
    }

    public function destroy(PromoVideo $promoVideo)
    {
        if ($promoVideo->video_path && Storage::disk('public')->exists($promoVideo->video_path)) {
            Storage::disk('public')->delete($promoVideo->video_path);
        }
        
        $promoVideo->delete();

        return redirect()->back()->with('success', 'Video promo berhasil dihapus!');
    }
}
