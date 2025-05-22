@extends('layouts.app')

@section('content')
<style>
    body,
    html {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .dashboard-container {
        display: flex;
        height: 100vh;
    }

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

    /* Comment section styles */
    .comments-container {
        background-color: #ebebeb;
        border-radius: 12px;
        padding: 20px;
        margin-top: 30px;
    }

    .comment-item {
        margin-bottom: 20px;
        border-bottom: 1px solid #d0d0d0;
        padding-bottom: 20px;
    }

    .comment-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .comment-actions {
        position: relative;
    }

    .comment-menu-toggle {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        transform: rotate(90deg);
        padding: 0;
        line-height: 0.5;
    }

    .comment-menu {
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 10;
        width: 120px;
    }

    .comment-menu a,
    .comment-menu button {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
    }

    .comment-menu button {
        color: #f44336;
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
        box-shadow: 0 2px 8px rgba(33, 150, 243, 0.1);
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
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7));
        border-radius: 16px;
    }

    .article-header-content {
        position: relative;
        padding: 40px;
        width: 100%;
        color: white;
    }

    .article-meta-white {
        color: rgba(255, 255, 255, 0.8);
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
        flex-direction: row;
        align-items: center;
    }

    .btn-edit-article,
    .btn-delete-article {
        height: 40px;
        background: #ff9800;
        color: white;
        border: none;
        border-radius: 24px;
        padding: 10px 24px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        gap: 8px;
        margin: 0;
        vertical-align: middle;
    }

    .btn-delete-article {
        background: #f44336;
    }

    .article-container {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(33, 150, 243, 0.1);
    }
</style>

<div class="dashboard-container">
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
                    <button onclick="location.href='{{ route('articles.edit', $article->id) }}';" class="btn-edit-article">
                        Edit Article
                    </button>
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

            <!-- Comments section -->
            <div class="comments-container" style="background-color: #ebebeb; border-radius: 12px; padding: 20px; margin-top: 30px;">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 1.5rem; font-weight: bold;">Comment ({{ $article->comments->count() ?? 10 }})</h2>

                <!-- Add new comment form -->
                <div style="background-color: white; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                    <form action="{{ route('comments.store', $article->id) }}" method="POST">
                        @csrf
                        <input type="text" name="body" placeholder="Write a Comment" style="width: 100%; border: none; outline: none; padding: 8px 0; font-size: 1rem;">
                        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                            <button type="submit" style="background-color: #34558b; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; font-weight: 500;">Submit</button>
                        </div>
                    </form>
                </div>

                <!-- Comments list -->
                @foreach($article->comments ?? [1, 2, 3] as $comment)
                <div class="comment-item" style="margin-bottom: 20px; border-bottom: 1px solid #d0d0d0; padding-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div style="display: flex; gap: 15px;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #d5d5d5; overflow: hidden;">
                                <img src="{{ asset('images/profile-icon.svg') }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <div style="font-weight: bold; margin-bottom: 5px;">
                                    {{ $comment->user->name ?? 'Bukan pinsentius dilen' }}
                                </div>
                                <div style="color: #777; font-size: 0.9rem; margin-bottom: 10px;">
                                    {{ $comment->created_at ? $comment->created_at->diffForHumans() : '1 hour ago' }}
                                </div>
                                <div>
                                    {{ $comment->body ?? 'Keren banget sumpah, aku termotivasi omaygat' }}
                                </div>
                            </div>
                        </div>
                        <div class="comment-actions" style="position: relative;">
                            <button class="comment-menu-toggle" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; font-weight: bold; color: #333; transform: rotate(90deg); padding: 0; line-height: 0.5;">⋮</button>
                            <div class="comment-menu" style="position: absolute; right: 0; top: 100%; background: white; border-radius: 6px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: none; z-index: 10; width: 120px;">
                                <a href="#" onclick="editComment({{ $comment->id ?? 1 }})" style="display: block; padding: 10px 15px; text-decoration: none; color: #333;">Edit</a>
                                <form action="{{ route('comments.destroy', $comment->id ?? 1) }}" method="POST" style="display: block; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 10px 15px; cursor: pointer; color: #f44336;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Back button -->
            <div style="margin-top: 30px;">
                <a href="{{ url()->previous() }}" style="color: #2876E9; font-weight: 600; display: flex; align-items: center; gap: 5px; text-decoration: none;">
                    <span>←</span> Back
                </a>
            </div>
        </div>

        <div class="trending-column">
            <div class="trending-header">
                Trending on Blogify
            </div>
            <div class="trending-items">
                @forelse($trendingArticles as $trendingArticle)
                <a href="{{ route('articles.show', $trendingArticle->slug ) }}" class="trending-item">
                    <img src="{{ $trendingArticle->thumbnail ? asset('storage/' . $trendingArticle->thumbnail) : asset('images/default-blog.jpg') }}"
                        alt="{{ $trendingArticle->title }}" class="trending-item-image">
                    <div class="trending-item-content">
                        <h3>{{ $trendingArticle->title }}</h3>
                        <div class="trending-item-meta">
                            {{ $trendingArticle->published_at->format('M d, Y') }} • {{ $trendingArticle->read_time }} min read
                        </div>
                    </div>
                </a>
                @empty

                <div class="trending-item">
                    <div class="trending-item-content">
                        <h3>No trending articles available</h3>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButtons = document.querySelectorAll('.comment-menu-toggle');

        menuButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.nextElementSibling;

                document.querySelectorAll('.comment-menu').forEach(m => {
                    if (m !== menu) m.style.display = 'none';
                });

                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });

        document.addEventListener('click', function() {
            document.querySelectorAll('.comment-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        });
    });

    function editComment(commentId) {
        const commentItem = event.target.closest('.comment-item');
        const commentText = commentItem.querySelector('div > div:nth-child(2) > div:nth-child(3)').textContent.trim();

        const commentContent = commentItem.querySelector('div > div:nth-child(2) > div:nth-child(3)');
        commentContent.innerHTML = `
            <form action="/comments/${commentId}" method="POST" style="display: flex; gap: 10px;">
                @csrf
                @method('PUT')
                <input type="text" name="body" value="${commentText}" style="flex: 1; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                <button type="submit" style="background-color: #2876E9; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">Save</button>
                <button type="button" onclick="cancelEdit(this, '${commentText}')" style="background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px; padding: 8px 12px; cursor: pointer;">Cancel</button>
            </form>
        `;

        document.querySelectorAll('.comment-menu').forEach(menu => {
            menu.style.display = 'none';
        });

        event.preventDefault();
    }

    function cancelEdit(button, originalText) {
        const form = button.closest('form');
        const commentContent = form.parentElement;
        commentContent.innerHTML = originalText;
    }
</script>