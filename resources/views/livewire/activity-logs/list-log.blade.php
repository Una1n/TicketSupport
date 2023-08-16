<div>
    <x-status />
    <div class="mb-5 text-2xl font-bold">Ticket Activity Logs</div>
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Title</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Description</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Caused By</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-400">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <a href="{{ route('logs.show', $log) }}" class="text-blue-700 hover:text-blue-900">
                                {{ $log->subject->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $log->description }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $log->causer?->name }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-white p-4">{{ $logs->links() }}</div>
    </div>

</div>
