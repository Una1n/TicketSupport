<div>
    <x-status />
    <div class="mb-5 text-2xl font-bold">Tickets</div>
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
        <div class="flex justify-between bg-white">
            <div class="flex">
                <div class="flex items-center gap-2 p-4">
                    <select wire:model.live="categoryFilter"
                        class="focus:border-primary-300 focus:ring-primary-200 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50">
                        <option value="">- Select Category -</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2 p-4">
                    <select wire:model.live="priorityFilter"
                        class="focus:border-primary-300 focus:ring-primary-200 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50">
                        <option value="">- Select Priority -</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 p-4">
                    <select wire:model.live="statusFilter"
                        class="focus:border-primary-300 focus:ring-primary-200 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50">
                        <option value="">- Select Status -</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 p-4">
                <input type="text" wire:model.live="search"
                    class="focus:border-primary-400 focus:ring-primary-200 w-30 block rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500"
                    placeholder="Search..." />
            </div>
        </div>
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Title</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Author</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Priority</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Status</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Assigned To</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Categories</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Labels</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-700 hover:text-blue-900">
                                {{ $ticket->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $ticket->user->name }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <span @class([
                                'inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold',
                                'bg-green-200 text-green-700' => $ticket->priority === 'low',
                                'bg-yellow-200 text-yellow-700' => $ticket->priority === 'medium',
                                'bg-red-200 text-red-700' => $ticket->priority === 'high',
                            ])>
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            @if ($ticket->status === 'closed')
                                <span class="text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $ticket->agent->name ?? '' }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            @foreach ($ticket->categories as $category)
                                <span class="rounded-full bg-blue-400 px-2 py-1 text-xs">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            @foreach ($ticket->labels as $label)
                                <span class="rounded-full bg-orange-400 px-2 py-1 text-xs">{{ $label->name }}</span>
                            @endforeach
                        </td>
                        <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                            @canany(['manage tickets', 'edit tickets'])
                                <a href="{{ route('tickets.edit', $ticket) }}"
                                    class="rounded-full bg-blue-400 px-4 py-1 text-blue-800 hover:bg-blue-500 hover:text-white">Edit</a>
                            @endcan
                            @can('manage tickets')
                                <button wire:confirm="Are you sure you want to delete this ticket?"
                                    wire:click="deleteTicket({{ $ticket }})"
                                    class="rounded-full bg-red-400 px-4 py-1 text-red-800 hover:bg-red-500 hover:text-white">Delete</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-white p-4">{{ $tickets->links() }}</div>
    </div>

    <div class="mt-8">
        <a href="{{ route('tickets.create') }}"
            class="rounded-lg border border-green-500 bg-green-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-green-700 hover:bg-green-700 focus:ring focus:ring-green-200 disabled:cursor-not-allowed disabled:border-green-300 disabled:bg-green-300">
            Create Ticket
        </a>
    </div>

</div>
