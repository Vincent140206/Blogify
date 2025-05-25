@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/myblogs.css') }}">
<div class="my-blogs-container">
    <!-- Sidebar -->
    @include('partials.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header-row">
            <h1>My Blogs</h1>
        </div>
        <a href="{{ route('articles.create') }}" class="create-btn">
            Create Article
        </a>

        <!-- Stats Info -->
        <div class="stats-info">
            <h3>Your Blog Statistics</h3>
            <p>You have {{ $articles->count() }} published articles</p>
        </div>

        <div class="header-row-2">
            <span class="subheader">Manage your personal blog articles</span>
            <form class="search-bar" method="GET">
                <span style="font-size:1.3rem; color:#888;">&#128269;</span>
                <input type="text" name="q" placeholder="Search your articles" value="{{ request('q') }}">
            </form>
        </div>

        @if($articles->count() > 0)
        <div class="articles-grid">
            @foreach($articles as $article)
            <a href="{{ route('articles.show', $article->slug) }}" class="article-card">
                @if($article->thumbnail)
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="article-img">
                @else
                <img src="{{ asset('images/article-placeholder.jpg') }}" alt="Article Image" class="article-img">
                @endif

                <div class="article-content">
                    <h2 class="article-title">{{ $article->title }}</h2>
                    <p class="article-author">By You</p>

                    <div class="article-meta-group">
                        <span class="article-date">{{ $article->created_at->format('M d, Y') }}</span>
                        @if($article->views)
                        <span class="article-views">{{ number_format($article->views) }} views</span>
                        @endif
                        @if($article->read_time)
                        <span class="article-read-time">{{ $article->read_time }} min read</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="no-articles">
            <h3>No Articles Yet</h3>
            <p>You haven't published any articles yet. Start creating your first blog post!</p>
            <a href="{{ route('articles.create') }}" class="create-btn">
                Create Your First Article
            </a>
        </div>
        @endif
    </div>
</div>
@endsection