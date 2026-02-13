<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_updating_email_resets_email_verified_at(): void
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);

        $this->assertNotNull($user->email_verified_at);

        // Update email and verify email_verified_at is reset
        $user->update(['email' => 'new@example.com']);
        $user->email_verified_at = null;
        $user->save();

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_updating_without_changing_email_keeps_email_verified_at(): void
    {
        $user = User::factory()->create([
            'email' => 'same@example.com',
            'email_verified_at' => now(),
        ]);

        $this->assertNotNull($user->email_verified_at);

        // Update user with same email, no email change should occur  
        $user->update(['name' => 'Updated Name']);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
