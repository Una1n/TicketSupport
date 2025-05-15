<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    use Toast;

    public UserForm $form;

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function save(): void
    {
        $this->authorize('manage', User::class);

        $this->form->store();

        $this->success(
            'User ' . $this->form->name . ' created!',
            /** @phpstan-ignore property.notFound */
            description: 'Role: ' . $this->form->user->roles->first()->name,
            redirectTo: route('users.index')
        );
    }

    public function render(): View
    {
        return view('livewire.users.create-user', [
            'roles' => Role::all(),
        ]);
    }
}
