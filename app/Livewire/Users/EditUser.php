<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Validation\Rule;
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
        $this->validateOnly('form.email', [
            'form.email' => [
                // TODO: This doesn't work in Livewire/Form,
                // because the user doesn't get set before the rules are set
                Rule::unique('users', 'email')->ignore($this->form->user->id),
            ],
        ], [], ['form.email' => 'email']);

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
