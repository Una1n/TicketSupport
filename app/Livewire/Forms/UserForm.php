<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Auth;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    #[Rule(['required', 'min:3', 'max:255'])]
    public string $name = '';
    public string $email = '';

    #[Rule(['required', 'min:8', 'max:255'])]
    public string $password = '';

    public function rules()
    {
        return [
            'email' => [
                'required',
                // TODO: Find a fix for this
                // ValidationRule::unique('users', 'email')->ignore(optional($this->user)->id),
                'min:3',
                'max:255',
            ],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function store(): void
    {
        $this->allowed();

        // Still needed even though the docs say it runs automatically
        $this->validate();

        User::create(
            $this->only(['name', 'email', 'password'])
        );
    }

    public function update(): void
    {
        $this->allowed();
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    private function allowed(): void
    {
        if (! Auth::user()->can('manage', User::class)) {
            abort(403);
        }
    }
}
