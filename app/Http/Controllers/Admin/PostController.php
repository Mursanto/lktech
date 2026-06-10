<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use \App\Traits\UploadsImage;
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['thumbnail']);
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        
        $data['is_published'] = $request->has('is_published');
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->compressAndStore($request->file('thumbnail'), 'blogs');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['thumbnail']);
        
        // Update slug if title changed significantly (optional, keeping it simple here)
        if ($request->title !== $post->title) {
            $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        }

        $data['is_published'] = $request->has('is_published');
        
        // If it wasn't published and now is, set the published_at date
        if ($data['is_published'] && !$post->is_published) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $this->compressAndStore($request->file('thumbnail'), 'blogs');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
