<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class BlogController extends Controller
{
  public function create()
  {
    return view('blog.create'); 
  }

  public function index(Request $request)
    {
      $query = $request->input('q');

      $articles = Article::when($query, function ($q) use ($query) {
          $q->where('title', 'like', "%{$query}%");
      })->latest()->get();

      return view('dashboard', compact('articles'));
    }

}