@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
<div class="dashboard-container">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="header-row">
            <h1>Edit Blog</h1>
        </div>
        <hr style="border: none; height: 2px; background-color: #ccc;">
        @if ($errors->any())
        <div class="alert alert-danger" style="background: #ffebee; color: #d32f2f; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="create-form-container" style="background: white; margin-top: 20px; border-radius: 16px; padding: 30px; box-shadow: 0 2px 8px rgba(33,150,243,0.1);">
            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Thumbnail</label>
                    <div class="upload-area" id="upload-area">
                        <img id="thumbnail-preview-img" 
                             src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('images/Upload_Image.png') }}" 
                             class="{{ $article->thumbnail ? '' : 'default-icon' }}" 
                             alt="Thumbnail Preview">
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="title" style="display: block; margin-bottom: 8px; font-weight: 600;">Blog Title</label>
                    <input type="text" name="title" id="title" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;" value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="body" style="display: block; margin-bottom: 8px; font-weight: 600;">Blog Content</label>
                    <textarea name="body" id="body" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; min-height: 300px;" required>{{ old('body', $article->body) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="read_time" style="display: block; margin-bottom: 8px; font-weight: 600;">Read Time (minutes)</label>
                    <input type="number" name="read_time" id="read_time" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;" value="{{ old('read_time', $article->read_time) }}" min="1">
                    <small style="color: #666; display: block; margin-top: 5px;">Leave empty to calculate automatically based on content length</small>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: center;">
                        <input type="checkbox" name="is_published" id="is_published" value="1" style="margin-right: 10px;" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                        <label for="is_published" style="font-weight: 600;">Publish immediately</label>
                    </div>
                </div>

                <div class="form-buttons" style="display: flex; gap: 15px;">
                    <button type="submit" class="btn-primary" style="background: #2876E9; color: white; border: none; border-radius: 24px; padding: 12px 28px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                        Update Blog Post
                    </button>
                    <a href="{{ route('articles.my-blogs') }}" class="btn-secondary" style="background: #e0e0e0; color: #444; border: none; border-radius: 24px; padding: 12px 28px; font-size: 1.1rem; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/create.js') }}"></script>
@endsection
