<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with('user')
            ->published()
            ->when($request->q, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->paginate(12);

        return view('dashboard', compact('articles'));
    }
}
