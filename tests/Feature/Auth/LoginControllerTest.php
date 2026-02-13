<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_viewed(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('login.index');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'nama' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john.doe@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'nama' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane.doe@gmail.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'jane.doe@gmail.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_cannot_login_with_non_existent_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@gmail.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
