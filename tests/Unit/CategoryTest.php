<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_category()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('categories.store'), ['name' => 'PHP'])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'PHP', 'user_id' => $user->id]);
    }

    public function test_user_cannot_edit_other_users_category()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
            ->patch(route('categories.update', $category->id), ['name' => 'Updated'])
            ->assertForbidden();
    }

    public function test_user_cannot_delete_other_users_category()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
            ->delete(route('categories.destroy', $category->id))
            ->assertForbidden();
    }
}

