@extends('layouts.app')

@section('content')
<style>
    body, html { height: 100%; width: 100%; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; }
    .dashboard-container { display: flex; height: 100vh; }
    .sidebar {
        width: 90px;
        background: #2876E9;
        display: flex;
        flex-direction: column;
        justify-content: flex-start; 
        align-items: flex-start;
        padding: 30px 20px;
        transition: width 0.3s ease;
        overflow: hidden;
        height: 100vh; 
    }

    .sidebar:hover {
        width: 280px;
        align-items: flex-start;
        padding-left: 20px;
    }
    .sidebar-top {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .sidebar img.logo,
    .sidebar img.profile {
        width: 48px;
        transition: transform 0.3s;
    }
    .sidebar-menu {
        display: flex;
        flex-direction: column;
        margin-top: 40px;
        width: 100%;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    .sidebar:hover .sidebar-menu {
        opacity: 1;
        pointer-events: auto;
    }
    .sidebar-menu a {
        color: white;
        text-decoration: none;
        padding: 12px 10px;
        border-radius: 8px;
        transition: background 0.2s;
        align-items: center;
        margin-bottom: 10px
    }
    .sidebar-menu a:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px
    }
    .sidebar-bottom {
        margin-top: auto;
        width: 100%;
        padding: 10px 20px;
        box-sizing: border-box;
        color: white;
    }
    .divider {
        border: none;
        border-top: 1px solid white;
        margin-bottom: 12px;
        opacity: 0.6;
    }
    .profile-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .profile {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
    .user-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .user-name {
        font-weight: bold;
        font-size: 1rem;
    }
    .user-email {
        font-size: 0.85rem;
        opacity: 0.8;
    }
    .logout-btn {
        background: transparent;
        border: 1.5px solid white;
        border-radius: 20px;
        padding: 6px 14px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s, color 0.2s;
    }
    .logout-btn:hover {
        background-color: white;
        color: #2876E9; 
    }
    .sidebar img.profile {
        width: 48px;
        border-radius: 50%;
    }
    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-left: 0;
        width: 100%;
    }
    .logo-text {
        color: white;
        font-size: 1.3rem;
        font-weight: bold;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .sidebar:hover .logo-text {
        opacity: 1;
    }
    .sidebar-menu a.active {
        background: rgba(255, 255, 255, 0.4);
        font-weight: bold;
        border-radius: 15px;
        border: 2px solid rgba(255, 255, 255, 0.4);
        gap: 12px;
        padding: 12px 10px;
        text-decoration: none;
    }
    .sidebar-menu a .menu-icon {
        width: 20px;
        height: 16px;
        margin-right: 8px;
    }
    .logout-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .logout-btn img {
        width: 24px;
        height: 24px;
    }
    
    /* Main content container with grid layout */
    .main-content {
        flex: 1;
        padding: 30px;
        background-color: #f5f7fa;
        overflow-y: auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }
    
    /* Article column */
    .article-column {
        grid-column: 1;
    }
    
    /* Trending column */
    .trending-column {
        grid-column: 2;
        background-color: white;
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(33,150,243,0.1);
        height: fit-content;
    }
    
    .trending-header {
        background-color: #34558b;
        color: white;
        padding: 20px;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        font-size: 1.8rem;
        font-weight: bold;
    }
    
    .trending-items {
        padding: 20px;
    }
    
    .trending-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        text-decoration: none;
        color: inherit;
    }
    
    .trending-item:last-child {
        margin-bottom: 0;
    }
    
    .trending-item-image {
        width: 120px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .trending-item-content h3 {
        margin: 0 0 8px 0;
        font-size: 1.1rem;
        color: #222;
    }
    
    .trending-item-meta {
        font-size: 0.9rem;
        color: #777;
    }

    .article-body {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    .article-body p {
        margin-bottom: 20px;
    }
    .article-body img {
        max-width: 100%;
        border-radius: 8px;
        margin: 20px 0;
    }
    .article-body h2 {
        margin-top: 30px;
        margin-bottom: 15px;
        font-size: 1.8rem;
    }
    .article-body h3 {
        margin-top: 25px;
        margin-bottom: 15px;
        font-size: 1.5rem;
    }
    .article-header {
        position: relative;
        height: 400px;
        background-size: cover;
        background-position: center;
        border-radius: 16px;
        margin-bottom: 30px;
        display: flex;
        align-items: flex-end;
    }
    .article-header-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));
        border-radius: 16px;
    }
    .article-header-content {
        position: relative;
        padding: 40px;
        width: 100%;
        color: white;
    }
    .article-meta-white {
        color: rgba(255,255,255,0.8);
        display: flex;
        gap: 20px;
        margin-top: 15px;
        font-size: 1rem;
    }
    .author-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }
    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }
    .action-buttons {
        margin-top: 30px;
        display: flex;
        gap: 15px;
    }
    .btn-edit-article {
        background: #ff9800;
        color: white;
        border: none;
        border-radius: 24px;
        padding: 10px 24px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-delete-article {
        background: #f44336;
        color: white;
        border: none;
        border-radius: 24px;
        padding: 10px 24px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .article-container {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 2px 8px rgba(33,150,243,0.1);
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar (Same as before) -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/Blogify.png') }}" alt="Logo" class="logo">
            <span class="logo-text">Blogify</span>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <img src="{{ asset('images/Dashboard_icon.png') }}" class="menu-icon" />
                Dashboard
            </a>
            <a href="{{ route('articles.my-blogs') }}" class="{{ Request::is('my-blogs*') ? 'active' : '' }}">
                <img src="{{ asset('images/Myblog_icon.png') }}" class="menu-icon" />
                My Blogs
            </a>
            <a href="#" class="{{ Request::is('settings') ? 'active' : '' }}">
                <img src="{{ asset('images/Settings_icon.png') }}" class="menu-icon" />
                Settings
            </a>
        </div>

        <div class="sidebar-bottom">
            <hr class="divider" />
            <div class="profile-info">
                <a href="{{ route('profile') }}">
                    <img src="{{ asset('images/profile-icon.svg') }}" alt="Profile" class="profile" />
                </a>
                <div class="user-details">
                    <div class="user-name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                    <div class="user-email">{{ Auth::check() ? Auth::user()->email : '' }}</div>
                </div>
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <img src="{{ asset('images/Logout.png') }}" style="width: 24px; height: 24px;">
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="login-btn" style="color: white; text-decoration: none;">Login</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content with two columns -->
    <div class="main-content">
        <!-- Article Column -->
        <div class="article-column">
            @if (session('success'))
            <div class="alert alert-success" style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
            @endif
            
            <!-- Article Header with Background Image -->
            <div class="article-header" style="background-image: url('{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('images/default-blog.jpg') }}');">
                <div class="article-header-overlay"></div>
                <div class="article-header-content">
                    <h1 style="font-size: 2.5rem; margin-bottom: 10px;">{{ $article->title }}</h1>
                    
                    <div class="article-meta-white">
                        <span>{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                        <span>{{ $article->read_time }} min read</span>
                        <span>{{ $article->views }} views</span>
                    </div>
                    
                    <div class="author-info">
                        <img src="{{ asset('images/profile-icon.svg') }}" alt="{{ $article->user->name }}" class="author-avatar">
                        <div>
                            <div style="font-weight: 600;">{{ $article->user->name }}</div>
                            <div style="font-size: 0.9rem; opacity: 0.9;">Author</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Article content -->
            <div class="article-container">
                <div class="article-body">
                    {!! nl2br(e($article->body)) !!}
                </div>
                
                @auth
                    @can('update', $article)
                    <div class="action-buttons">
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn-edit-article">
                            Edit Article
                        </a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-article">
                                Delete Article
                            </button>
                        </form>
                    </div>
                    @endcan
                @endauth
            </div>
            
            <!-- Back button -->
            <div style="margin-top: 30px;">
                <a href="{{ url()->previous() }}" style="color: #2876E9; font-weight: 600; display: flex; align-items: center; gap: 5px; text-decoration: none;">
                    <span>←</span> Back
                </a>
            </div>
        </div>
        
        <!-- Trending Column -->
        <div class="trending-column">
            <div class="trending-header">
                Trending on Blogify
            </div>
            <div class="trending-items">
                <!-- Trending Item 1 -->
                <a href="#" class="trending-item">
                    <img src="{{ asset('images/burger.jpg') }}" alt="Fast Food" class="trending-item-image">
                    <div class="trending-item-content">
                        <h3>Fast Food Polemic: The Truth of Burger</h3>
                        <div class="trending-item-meta">Jun 26, 2024 • 12 min read</div>
                    </div>
                </a>
                
                <!-- Trending Item 2 -->
                <a href="#" class="trending-item">
                    <img src="{{ asset('images/bad-person.jpg') }}" alt="Bad Person" class="trending-item-image">
                    <div class="trending-item-content">
                        <h3>Fast Food Polemic: The Truth of Burger</h3>
                        <div class="trending-item-meta">Jun 26, 2024 • 12 min read</div>
                    </div>
                </a>
                
                <!-- Trending Item 3 -->
                <a href="#" class="trending-item">
                    <img src="{{ asset('images/workout.jpg') }}" alt="Workout" class="trending-item-image">
                    <div class="trending-item-content">
                        <h3>Fast Food Polemic: The Truth of Burger</h3>
                        <div class="trending-item-meta">Jun 26, 2024 • 12 min read</div>
                    </div>
                </a>
                
                <!-- Trending Item 4 -->
                <a href="#" class="trending-item">
                    <img src="{{ asset('images/countries.jpg') }}" alt="Countries" class="trending-item-image">
                    <div class="trending-item-content">
                        <h3>Fast Food Polemic: The Truth of Burger</h3>
                        <div class="trending-item-meta">Jun 26, 2024 • 12 min read</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection