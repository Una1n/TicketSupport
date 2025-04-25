<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
        $agents = User::factory(5)->agent()->create();

        Ticket::factory(25)
            ->categories()
            ->labels()
            ->recycle($users)
            ->agent($agents)
            ->create();
    }
}
