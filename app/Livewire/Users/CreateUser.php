<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    #[Validate(['required', 'min:3', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'email', 'unique:users,email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'min:8', 'max:255'])]
    public string $password = '';

    #[Validate(['required', 'exists:roles,id'])]
    public string $role = '';

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', User::class);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        $user = User::create(
            $this->only(['name', 'email', 'password'])
        );

        $role = Role::whereId($this->role)->first();
        $user->assignRole($role);

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->name . ' created.');
    }

    public function render(): View
    {
        return view('livewire.users.create-user', [
            'roles' => Role::all(),
        ]);
    }
}
