<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Profile::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'status' => 'active',
            'image_path' => 'image/' . $this->faker->image('public', 400, 300, null, false),  // image factice
            'admin_id' => Admin::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
