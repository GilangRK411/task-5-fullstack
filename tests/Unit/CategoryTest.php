<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category()
    {
        $category = Category::create(['name' => 'Laravel']);

        $this->assertDatabaseHas('categories', ['name' => 'Laravel']);
    }
}
