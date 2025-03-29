<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller {
    public function index() {
        $articles = Article::with('category', 'user')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create() {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();
        $data['published'] = $request->has('published');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Article::create($data);
        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }

    public function edit(Article $article) {
        $this->authorize('update', $article);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article) {
        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['published'] = $request->has('published');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);
        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article) {
        $this->authorize('delete', $article);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}

