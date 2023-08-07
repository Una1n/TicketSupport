<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditUser extends Component
{
    public UserForm $form;

    public function mount(User $user): void
    {
        $this->form->setUser($user);
    }

    public function save()
    {
        $this->form->update();

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->form->name . ' updated.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
