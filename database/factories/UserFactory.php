<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'                  => $this->faker->name(),
            'email'                 => $this->faker->unique()->safeEmail(),
            'volunteering_history'  => $this->faker->paragraph,
            'date_of_birth'         => $this->faker->date,
            'job'                   => $this->faker->jobTitle,
            'phone'                 => $this->faker->phoneNumber,
            'location'              => $this->faker->country,
            'gender'                => $this->faker->numberBetween(0,1),
            'email_verified_at'     => now(),
            'password'              => Hash::make('password'), // password
            'remember_token'        => Str::random(10),
        ];
    }
}
