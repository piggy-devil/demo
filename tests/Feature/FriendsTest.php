<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FriendsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_send_a_friend_request()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');
        $anotherUser = factory(\App\User::class)->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $friendRequest = \App\Friend::first();

        $this->assertNotNull($friendRequest);
        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ]
            ],
            'links' => [
                'self' => url('/users/'.$anotherUser->id),
            ]
        ]);
    }

    /** @test */
    public function only_valid_users_can_be_friend_requested()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 123,
        ])->assertStatus(404);

        $this->assertNull(\App\Friend::first());
        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'User Not Found',
                'detail' => 'Unable to locate the user with the given information.',
            ]
        ]);
    }

    /** @test */
    public function friend_requests_can_be_accepted()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');
        $anotherUser = factory(\App\User::class)->create();
        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(200);

        $friendRequest = \App\Friend::first();
        $this->assertNotNull($friendRequest->confirmed_at);
        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);
        $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);
        $this->assertEquals(1, $friendRequest->status);
        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
                ]
            ],
            'links' => [
                'self' => url('/users/'.$anotherUser->id),
            ]
        ]);
    }
}
