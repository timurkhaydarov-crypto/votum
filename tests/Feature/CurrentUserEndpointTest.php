<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CurrentUserEndpointTest extends TestCase
{
    public function test_guest_receives_a_successful_empty_current_user_response(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertOk();
        $response->assertContent('null');
    }

    public function test_authenticated_user_is_returned_by_current_user_endpoint(): void
    {
        $user = User::factory()->make();
        $user->id = 1;

        $this->actingAs($user)
            ->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('email', $user->email);
    }
}
