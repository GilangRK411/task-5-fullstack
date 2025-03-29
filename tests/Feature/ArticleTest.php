<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_article()
    {
        $article = Article::factory()->create();

        $this->assertDatabaseHas('articles', [
            'title' => $article->title
        ]);
    }
}
