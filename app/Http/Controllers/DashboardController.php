<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalArticles' => Article::count(),
            'totalCategories' => Category::count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),
            'latestArticles' => Article::latest()->take(5)->get(),
        ]);
    }
}
