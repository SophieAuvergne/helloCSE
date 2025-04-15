<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateProfile(): void
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'sanctum');

        Storage::fake('public');

        $response = $this->postJson('/api/profiles', [
            'name' => 'Name',
            'firstname' => 'Firstname',
            'status' => 'active',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profiles', [
            'name' => 'Name',
            'firstname' => 'Firstname',
            'admin_id' => $admin->id,
        ]);
    }

    public function testGuestCannotCreateProfile(): void
    {
        $response = $this->postJson('/api/profiles', [
            'name' => 'Name',
            'firstname' => 'Firstname',
            'status' => 'active',
        ]);

        $response->assertStatus(401);
    }

    public function testAdminCanDeleteProfile()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'sanctum');
        $profile = Profile::factory()->create(['admin_id' => $admin->id]);

        $response = $this->actingAs($admin)->deleteJson('/api/profiles/' . $profile->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('profiles', [
            'id' => $profile->id
        ]);
    }

    public function testGuestCannotDeleteProfile()
    {
        $profile = Profile::factory()->create();

        $response = $this->deleteJson('/api/profiles/' . $profile->id);

        $response->assertStatus(401);
    }

    public function testAdminCanUpdateProfile()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'sanctum');
        $profile = Profile::factory()->create();

        $response = $this->actingAs($admin)->putJson('/api/profiles/' . $profile->id, [
            'name' => 'Updated Name',
            'firstname' => 'Updated Firstname',
            'status' => 'inactive',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'name' => 'Updated Name',
            'firstname' => 'Updated Firstname',
            'status' => 'inactive',
        ]);
    }

    public function testGuestCanViewAllProfiles()
    {
        $admin = Admin::factory()->create();
        Profile::factory()->count(3)->create(['admin_id' => $admin->id]);

        $response = $this->getJson('/api/profiles');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
