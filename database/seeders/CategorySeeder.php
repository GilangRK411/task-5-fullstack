<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Ambil user pertama

        Category::create([
            'name' => 'Laravel',
            'user_id' => $user->id,
        ]);

        Category::create([
            'name' => 'Vue.js',
            'user_id' => $user->id,
        ]);
    }
}

