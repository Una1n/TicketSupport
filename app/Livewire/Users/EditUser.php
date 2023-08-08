<?php

namespace App\Livewire\Users;

use App\Models\User;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;
    public string $name = '';
    public string $email = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['sometimes', 'min:8', 'max:255'],
        ];
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        if (! Auth::user()->can('manage', User::class)) {
            abort(403);
        }

        $this->user->update($this->validate());

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->name . ' updated.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
