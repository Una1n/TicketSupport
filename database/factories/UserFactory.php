<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    public function agent(): self
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::whereName('Agent')->first();
            $user->assignRole($role);
        });
    }

    public function admin(): self
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::whereName('Admin')->first();
            $user->assignRole($role);
        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if (! $user->hasAnyRole()) {
                $role = Role::whereName('Regular')->first();
                $user->assignRole($role);
            }
        });
    }
}
