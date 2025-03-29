<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory {
    protected $model = Article::class;

    public function definition() {
        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'content' => $this->faker->paragraphs(3, true),
            'thumbnail' => null,
            'published' => true,
            'category_id' => Category::factory(),
            'user_id' => User::factory(), // <-- Tambahkan ini
        ];
    }
}


