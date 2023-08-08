<?php

namespace App\Livewire\Users;

use App\Models\User;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateUser extends Component
{
    #[Rule(['required', 'min:3', 'max:255'])]
    public string $name = '';

    #[Rule(['required', 'email', 'unique:users,email', 'max:255'])]
    public string $email = '';

    #[Rule(['required', 'min:8', 'max:255'])]
    public string $password = '';

    public function save()
    {
        if (! Auth::user()->can('manage', User::class)) {
            abort(403);
        }

        // Still needed even though the docs say it runs automatically
        $this->validate();

        User::create(
            $this->only(['name', 'email', 'password'])
        );

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->name . ' created.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.users.create-user');
    }
}
