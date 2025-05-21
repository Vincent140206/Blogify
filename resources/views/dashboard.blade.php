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
    
    /* Main */
    .main-content {
        flex: 1;
        background: #f8f8f8;
        padding: 40px 40px 0 40px;
        overflow-y: auto; 
    }
    .header-row { display: flex; justify-content: space-between; align-items: center; }
    .header-row h1 { font-size: 2.5rem; margin: 0; }
    .header-row-2 {
        display: flex;
        align-items: center;
        justify-content: space-between; 
        gap: 20px;
    }
    .create-btn {
        background: #2876E9;
        color: #fff;
        border: none;
        border-radius: 24px;
        padding: 12px 28px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .create-btn:hover { background: #1565c0; }
    .subheader {
        margin: 0;
        font-size: 1.1rem;
        color: #555;
    }
    .search-bar {
        flex-grow: 1; 
        max-width: 80%; 
        display: flex;
        align-items: center;
        background: #e0e0e0;
        border-radius: 24px;
        padding: 12px 24px;
        font-size: 1.1rem;
        border: none;
        outline: none;
    }
    .search-bar input {
        border: none;
        background: transparent;
        width: 100%;
        font-size: 1.1rem;
        outline: none;
    }
    .articles-grid {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }
    .article-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(33,150,243,0.07);
        overflow: hidden;
        transition: box-shadow 0.2s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }
    .article-card:hover { box-shadow: 0 4px 16px rgba(33,150,243,0.13); }
    .article-img { width: 100%; height: 180px; object-fit: cover; }
    .article-content { padding: 18px 18px 10px 18px; }
    .article-title { font-size: 1.2rem; font-weight: bold; margin-bottom: 6px; }
    .article-author { color: #444; font-size: 1rem; margin-bottom: 8px; }
    .article-meta { color: #888; font-size: 0.95rem; }
    @media (max-width: 900px) {
        .main-content { padding: 20px 5vw 0 5vw; }
        .articles-grid { gap: 18px; }
    }
</style>
<div class="dashboard-container">
    <!-- Sidebar -->
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
            <a href="#" class="{{ Request::is('blogs*') ? 'active' : '' }}">
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
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <img src="{{ asset('images/Logout.png') }}" style="width: 24px; height: 24px;">
                    </button>
                </form>
            </div>
        </div>

    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="header-row">
            <h1>Blog Articles</h1>
        </div>
        <a href="{{ route('articles.create') }}" class="create-btn">
            <span style="font-size: 1.3rem;">➕</span> Create Article
        </a>

        <div class="header-row-2">
    <span class="subheader">News for your daily needs!</span>
    <form class="search-bar" method="GET">
        <span style="font-size:1.3rem; color:#888;">&#128269;</span>
        <input type="text" name="q" placeholder="Search" value="{{ request('q') }}">
    </form>
</div>
        <div class="articles-grid">
            <div class="article-card">
                <div class="article-content">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection