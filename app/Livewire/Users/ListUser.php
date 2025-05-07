<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListUser extends Component
{
    use Toast;
    use WithPagination;

    public array $headers = [];
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function mount()
    {
        $this->headers = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'customRoles', 'label' => 'Roles']
        ];
    }

    public function createUser(): Redirector|RedirectResponse
    {
        return redirect()->route('users.create');
    }

    public function editUser(User $user): Redirector|RedirectResponse
    {
        return redirect()->route('users.edit', $user);
    }

    public function deleteUser(User $user): void
    {
        $this->authorize('manage', $user);

        if (auth()->check() && auth()->user()->is($user)) {
            abort(403, 'You cannot delete your own account');
        }

        $name = $user->name;

        if ($user->delete()) {
            $this->success('User ' . $name . ' deleted!');
        } else {
            $this->error('User ' . $name . ' deletion failed!');
        }
    }

    public function render(): View
    {
        return view('livewire.users.list-user', [
            'users' => User::with('roles:name')->orderBy('name')->paginate(8),
        ]);
    }
}
