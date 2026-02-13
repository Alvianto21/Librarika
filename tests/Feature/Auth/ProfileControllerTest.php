<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/dashboard/profile');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/profile');

        $response
            ->assertOk()
            ->assertViewIs('dashboard.profile.index')
            ->assertViewHas('title', 'User Profile')
            ->assertViewHas('user', $user);
    }

    public function test_profile_view_contains_user_data(): void
    {
        $user = User::factory()->create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard/profile');

        $response
            ->assertOk()
            ->assertViewHas('user', $user)
            ->assertViewHas('title');
    }

    public function test_user_sees_their_own_profile(): void
    {
        $user1 = User::factory()->create(['nama' => 'User 1']);
        $user2 = User::factory()->create(['nama' => 'User 2']);

        $response = $this->actingAs($user1)
            ->get('/dashboard/profile');

        $response
            ->assertOk()
            ->assertViewHas('user', function ($viewUser) use ($user1) {
                return $viewUser->id === $user1->id;
            });
    }
}
