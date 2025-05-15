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

class EditUser extends Component
{
    use Toast;

    public UserForm $form;

    public function mount(User $user): void
    {
        $this->form->setUser($user);
    }

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function save(): void
    {
        $this->authorize('manage', $this->form->user);

        $this->form->update();

        $this->success(
            'User ' . $this->form->name . ' updated.',
            redirectTo: route('users.index')
        );
    }

    public function render(): View
    {
        return view('livewire.users.edit-user', [
            'roles' => Role::all(),
        ]);
    }
}
