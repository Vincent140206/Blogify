@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">

<div class="dashboard-container">
    <!-- Sidebar -->
    @include('partials.sidebar')

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
                        <img
                            src="{{ $article->user->photo_profile ? asset('storage/' . $article->user->photo_profile) : asset('images/default-avatar.jpg') }}"
                            alt="{{ $article->user->name }}"
                            class="author-avatar">
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
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showConfirmModal(this.form)" class="btn-delete-article">
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
                                <img
                                    src="{{ $comment->user && $comment->user->photo_profile ? asset('storage/' . $comment->user->photo_profile) : asset('images/default-avatar.jpg') }}"
                                    alt="{{ $comment->user->name ?? 'User' }}"
                                    class="author-avatar">

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

<!-- Modal Background -->
<div id="confirm-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Discard Blog?</h2>
        <p>If you discard this blog, you won't be able to recover it.</p>
        <button id="confirm-yes" class="btn-confirm">Yes, Delete</button>
        <button id="confirm-no" class="btn-cancel">Cancel</button>
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

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('confirm-modal');
        const btnYes = document.getElementById('confirm-yes');
        const btnNo = document.getElementById('confirm-no');
        let formToSubmit = null;

        window.showConfirmModal = function(form) {
            formToSubmit = form;
            modal.style.display = 'flex';
        }

        btnYes.addEventListener('click', () => {
            if (formToSubmit) formToSubmit.submit();
            modal.style.display = 'none';
        });

        btnNo.addEventListener('click', () => {
            modal.style.display = 'none';
            formToSubmit = null;
        });
    });
</script>