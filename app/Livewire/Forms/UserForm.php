<?php

namespace App\Livewire\Forms;

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
        $this->role = $user->roles()->first()->id;  /* @phpstan-ignore-line */
    }

    public function store(): void
    {
        $this->validate();

        $user = User::create($this->only([
            'name', 'email', 'password'
        ]));

        $this->user = $user;

        $role = Role::whereId($this->role)->first();
        $user->assignRole($role);
    }
}
