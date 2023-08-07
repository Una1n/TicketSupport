<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateUser extends Component
{
    public UserForm $form;

    public function save()
    {
        $this->form->store();

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->form->name . ' created.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.users.create-user');
    }
}
