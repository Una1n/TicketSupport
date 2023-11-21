<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateCategory extends Component
{
    #[Validate(['required', 'unique:categories,name', 'min:3', 'max:255'])]
    public string $name = '';

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', Category::class);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        Category::create(
            $this->only(['name'])
        );

        return redirect()->route('categories.index')
            ->with('status', 'Category ' . $this->name . ' created.');
    }

    public function render(): View
    {
        return view('livewire.categories.create-category');
    }
}
