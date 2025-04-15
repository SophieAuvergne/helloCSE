<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCommentProfile()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $profile = Profile::factory()->create();

        $response = $this->postJson('/api/profiles/'. $profile->id .'/comments', [
            'comment' => 'Lorem ipsum'
        ]);

        $response->assertStatus(201);
    }

    public function testGuestCannotCommentProfile()
    {
        $profile = Profile::factory()->create();

        $response = $this->postJson('/api/profiles/'. $profile->id .'/comments', [
            'comment' => 'Lorem ipsum'
        ]);

        $response->assertStatus(401);
    }
}
