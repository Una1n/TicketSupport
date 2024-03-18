<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;

    public function deleteUser(User $user): void
    {
        $this->authorize('manage', $user);

        if (auth()->check() && auth()->user() == $user) {
            abort(403, 'You cannot delete your own account');
        }

        $name = $user->name;

        $user->delete();

        session()->flash('status', 'User ' . $name . ' Deleted!');
    }

    public function render(): View
    {
        return view('livewire.users.list-user', [
            'users' => User::orderBy('name')->paginate(8),
        ]);
    }
}
