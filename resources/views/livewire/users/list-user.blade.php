<div>
    <x-mary-header title="Users" separator>
        <x-slot:actions>
            <x-mary-button icon="o-plus" label="Create" class="btn-primary" wire:click="createUser" responsive />
        </x-slot:actions>
    </x-mary-header>
    <x-mary-card>
        <x-mary-table :headers="$headers" :rows="$users" :sort-by="$sortBy" with-pagination>
            @scope('cell_name', $user)
                <div class="flex flex-col">
                    <div>{{ $user->name }}</div>
                    <div class="text-base-content/30 lg:hidden">{{ $user->email }}</div>
                </div>
            @endscope
            @scope('cell_customRoles', $user)
                <div class="flex flex-row gap-2">
                    @foreach ($user->roles as $role)
                        @if ($role->name === 'Regular')
                            <x-mary-badge value="{{ $role->name }}" class="badge-accent badge-soft" />
                        @elseif ($role->name === 'Agent')
                            <x-mary-badge value="{{ $role->name }}" class="badge-primary badge-soft" />
                        @elseif ($role->name === 'Admin')
                            <x-mary-badge value="{{ $role->name }}" class="badge-warning badge-soft" />
                        @endif
                    @endforeach
                </div>
            @endscope
            @scope('actions', $user)
                <div class="flex flex-row">
                    <x-mary-button icon="o-pencil-square" class="btn-ghost text-warning"
                        wire:click="editUser({{ $user }})" tooltip="Edit" />
                    <x-mary-button icon="o-trash" class="btn-ghost text-error"
                        wire:confirm="This will also delete all tickets from this user. Are you sure?"
                        wire:click="deleteUser({{ $user }})" tooltip="Delete" />
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>
</div>
