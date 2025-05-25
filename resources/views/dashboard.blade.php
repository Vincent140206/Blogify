@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="header-row">
                <h1>Blog Articles</h1>
            </div>
            <div class="header-row-2">
                <span class="subheader">News for your daily needs!</span>
                <form class="search-bar" method="GET" action="{{ route('dashboard') }}">
                    <input type="text" name="q" placeholder="Search" value="{{ request('q') }}">
                    <button type="submit" style="background:none; border:none; cursor:pointer; font-size:1.3rem; color:#888;">
                        &#128269;
                    </button>
                </form>

            </div>
            <div class="articles-grid">
                @foreach($articles as $article)
                <div class="article-wrapper">
                    <a href="{{ route('articles.show', $article->slug) }}" class="article-card">
                        @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="article-img">
                        @else
                        <img src="{{ asset('images/article-placeholder.jpg') }}" alt="Article Image" class="article-img">
                        @endif
                    </a>

                    <div class="article-content">
                        <a href="{{ route('articles.show', $article->slug) }}" style="text-decoration:none; color:inherit;">
                            <h2 class="article-title">{{ $article->title }}</h2>
                            <p class="article-author">By {{ $article->user->name }}</p>

                            <div class="article-meta-group">
                                <span class="article-date">{{ $article->created_at->format('M d, Y') }} •</span>
                                @if($article->views)
                                <span class="article-views">{{ number_format($article->views) }} views •</span>
                                @endif
                                @if($article->read_time)
                                <span class="article-read-time">{{ $article->read_time }} min read</span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection