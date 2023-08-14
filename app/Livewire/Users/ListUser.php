<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;

    public function deleteUser(User $user): void
    {
        $this->authorize('manage', $user);

        $name = $user->name;

        $user->delete();

        session()->flash('status', 'User ' . $name . ' Deleted!');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.users.list-user', [
            'users' => User::orderBy('name')->paginate(8),
        ]);
    }
}
