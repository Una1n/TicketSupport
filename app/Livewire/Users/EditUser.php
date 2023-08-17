<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public User $user;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';

    /**
     * @return array<string, array<string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['sometimes', 'min:8', 'max:255'],
            'role' => ['required', 'exists:roles,id'],
        ];
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles()->first()->id;  /* @phpstan-ignore-line */
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', $this->user);

        $validated = $this->validate();
        if (! empty($validated['role'])) {
            $this->user->roles()->sync([$validated['role']]);
            unset($validated['role']);
        }

        $this->user->update($validated);

        return redirect()->route('users.index')
            ->with('status', 'User ' . $this->name . ' updated.');
    }

    public function render(): View
    {
        return view('livewire.users.edit-user', [
            'roles' => Role::all(),
        ]);
    }
}
