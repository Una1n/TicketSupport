<div class="max-w-xl">
    <div class="mb-5 text-2xl font-bold">Create Ticket</div>
    <form wire:submit="save" class="space-y-5">
        <div>
            <label for="title"
                class="mb-1 block text-sm font-medium text-gray-700 after:ml-0.5 after:text-red-500 after:content-['*']">Title</label>
            <input type="text" id="title" wire:model="title" @class([
                'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50',
                'border-red-300 focus:border-red-300 focus:ring-red-200' => $errors->has(
                    'title'),
            ]) placeholder="Title" />
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="priority"
                class="mb-1 block text-sm font-medium text-gray-700 after:ml-0.5 after:text-red-500 after:content-['*']">Priority</label>
            <select wire:model.live="priority"
                class="focus:border-primary-300 focus:ring-primary-200 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div>
            <label for="description"
                class="mb-1 block text-sm font-medium text-gray-700 after:ml-0.5 after:text-red-500 after:content-['*']">Description</label>
            <textarea type="description" id="description" wire:model="description" rows="5" @class([
                'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50',
                'border-red-300 focus:border-red-300 focus:ring-red-200' => $errors->has(
                    'description'),
            ])
                placeholder="Explain the issue..."></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="categories" class="mb-1 block text-sm font-medium text-gray-700">Categories</label>
            <div class="flex space-x-6">
                @foreach ($categories as $category)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="categories[{{ $category->id }}]"
                            class="text-primary-600 focus:border-primary-300 focus:ring-primary-200 h-4 w-4 rounded border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                        <label for="categories[{{ $category->id }}]"
                            class="text-sm font-medium text-gray-700">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <label for="labels" class="mb-1 block text-sm font-medium text-gray-700">Labels</label>
            <div class="flex space-x-6">
                @foreach ($labels as $label)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="labels[{{ $label->id }}]"
                            class="text-primary-600 focus:border-primary-300 focus:ring-primary-200 h-4 w-4 rounded border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                        <label for="labels[{{ $label->id }}]"
                            class="text-sm font-medium text-gray-700">{{ $label->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit"
            class="rounded-lg border border-green-500 bg-green-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-green-700 hover:bg-green-700 focus:ring focus:ring-green-200 disabled:cursor-not-allowed disabled:border-green-300 disabled:bg-green-300">
            Submit
        </button>
    </form>
</div>
