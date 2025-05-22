<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        // Allow all users to view articles, but require auth for other actions
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        $articles = Article::with('user')
            ->published()
            ->when($request->search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('body', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->paginate(6);
            
        return view('articles.index', compact('articles'));
    }
    
    /**
     * Show articles by current user
     */
    public function myBlogs(Request $request)
    {
        $articles = Article::with('user')
            ->byUser(Auth::id())
            ->when($request->search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('body', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(6);
            
        return view('articles.my-blogs', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'read_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Set user_id to current user
        $validated['user_id'] = Auth::id();
        
        // Set published_at if published
        if ($request->is_published) {
            $validated['published_at'] = now();
        }
        
        $article = Article::create($validated);
        
        return redirect()->route('articles.show', $article->slug)
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with('user')
            ->firstOrFail();

        $article->incrementViewCount();

        $trendingArticles = Article::where('id', '!=', $article->id)
            ->whereNotNull('published_at')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'trendingArticles'));
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        // Check if user owns this article
        $this->authorize('update', $article);
        
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Check if user owns this article
        $this->authorize('update', $article);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'read_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Update published_at if publishing for the first time
        if ($request->is_published && !$article->published_at) {
            $validated['published_at'] = now();
        }
        
        $article->update($validated);
        
        return redirect()->route('articles.show', $article->slug)
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        // Check if user owns this article
        $this->authorize('delete', $article);
        
        // Delete thumbnail if exists
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        
        $article->delete();
        
        return redirect()->route('articles.my-blogs')
            ->with('success', 'Blog post deleted successfully!');
    }

}
