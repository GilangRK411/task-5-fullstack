@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Articles</h2>
    <a href="{{ route('articles.create') }}" class="btn btn-primary">Add Article</a>
    <table class="table mt-3">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        @foreach($articles as $article)
        <tr>
            <td>{{ $article->title }}</td>
            <td>{{ $article->category->name }}</td>
            <td>
                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $articles->links() }}
</div>
@endsection
