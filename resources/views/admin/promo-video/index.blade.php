@extends('layouts.app')

@section('title', 'Kelola Video Promo')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Video Promo Floating</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Upload Video Promo Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.promo-video.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul Promo</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Target (Opsional)</label>
                            <input type="url" name="target_url" class="form-control" placeholder="https://lktech.online/katalog">
                            <small class="text-muted">Link yang dituju ketika video di klik.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Video (MP4 / WebM)</label>
                            <input type="file" name="video" class="form-control" accept="video/mp4,video/webm" required>
                            <small class="text-muted">Maksimal 20MB. Rekomendasi rasio vertikal 9:16 atau 4:5, durasi 10-15 detik.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan & Aktifkan Video</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Video Aktif Saat Ini</h6>
                </div>
                <div class="card-body">
                    @if(isset($activeVideo) && $activeVideo)
                        <div class="text-center">
                            <h5>{{ $activeVideo->title }}</h5>
                            <video width="200" autoplay muted loop playsinline class="rounded my-3 shadow-sm" style="border: 2px solid #2563eb;">
                                <source src="{{ asset('storage/' . $activeVideo->video_path) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                            <p class="mb-0 text-muted"><strong>Target URL:</strong> {{ $activeVideo->target_url ?: '-' }}</p>
                            <p class="mb-0 text-muted"><strong>Diaktifkan pada:</strong> {{ $activeVideo->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">Belum ada video promo yang aktif.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
