<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Menggunakan refresh database untuk testing bersih setiap kali dijalankan

    /**
     * Test jika halaman utama dapat diakses tanpa login (opsional, sesuaikan dengan logika aplikasi).
     */
    public function test_homepage_redirects_if_not_logged_in(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302); // Redirect ke /login jika belum login
        $response->assertRedirect('/login'); // Pastikan redirect ke login
    }

    /**
     * Test jika halaman utama dapat diakses setelah login.
     */
    public function test_homepage_is_accessible_after_login(): void
    {
        $user = User::factory()->create(); // Buat user baru
        $this->actingAs($user); // Login sebagai user tersebut

        $response = $this->get('/');

        $response->assertStatus(200); // Harus bisa diakses
    }
}
