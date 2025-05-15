<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->text(),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['open', 'closed']),
            'user_id' => User::factory(),
        ];
    }

    public function categories(array|Collection $categories = []): self
    {
        return $this->afterCreating(function (Ticket $ticket) use ($categories) {
            if (! $categories) {
                $ticket->categories()->attach(Category::all()->random(rand(1, 3)));
            } else {
                $ticket->categories()->attach($categories);
            }
        });
    }

    public function labels(array|Collection $labels = []): self
    {
        return $this->afterCreating(function (Ticket $ticket) use ($labels) {
            if (! $labels) {
                $ticket->labels()->attach(Label::all()->random(rand(1, 2)));
            } else {
                $ticket->labels()->attach($labels);
            }
        });
    }

    public function user(mixed $user): self
    {
        return $this->afterCreating(function (Ticket $ticket) use ($user) {
            if (! $user instanceof Collection) {
                $ticket->user()->associate($user)->save();
            } else {
                $ticket->user()->associate($user->random())->save();
            }
        });
    }

    public function agent(mixed $user): self
    {
        return $this->afterCreating(function (Ticket $ticket) use ($user) {
            if (! $user instanceof Collection) {
                $ticket->agent()->associate($user)->save();
            } else {
                $ticket->agent()->associate($user->random())->save();
            }
        });
    }
}
