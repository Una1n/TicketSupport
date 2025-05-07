<?php

namespace App\Livewire\Forms;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class UserForm extends Form
{
    public ?User $user = null;

    public string $name;
    public string $email;
    public string $password;
    public string $role;

    /**
     * @return array<string, array<string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'password' => ['sometimes', 'min:8', 'max:255'],
            'role' => ['required', Rule::exists('roles', 'id')],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->role = $user->roles()->first()->id;  /* @phpstan-ignore-line */
    }

    public function store(): void
    {
        $this->validate();

        $this->user = User::create($this->except(['role', 'user']));

        $role = Role::whereId($this->role)->first();
        $this->user->assignRole($role);
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update($this->except(['role', 'user']));

        $oldRole = $this->user->roles()->first();
        $newRole = Role::whereId($this->role)->first();
        $this->user->syncRoles($newRole);

        // If we go from Agent to Regular, we remove this agent from tickets its assigned to
        if ($oldRole->name === 'Agent' && $newRole->name === 'Regular') {
            Ticket::whereAgentId($this->user->id)->update(['agent_id' => null]);
        }
    }
}
