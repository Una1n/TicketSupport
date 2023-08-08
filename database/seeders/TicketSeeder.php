<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $agents = User::factory(5)->create();
        $agentRole = Role::findByName('Agent');
        $agents->each->assignRole($agentRole);

        foreach ($agents as $agent) {
            Ticket::factory(5)->create([
                'agent_id' => $agent->id,
            ]);
        }
    }
}
