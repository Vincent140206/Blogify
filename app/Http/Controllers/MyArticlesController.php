<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class MyArticlesController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('user_id', Auth::id());
        
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        $articles = $query->with('user')
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        return view('articles.my-blogs', compact('articles'));
    }
}