<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Auth;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateCategory extends Component
{
    #[Rule(['required', 'unique:categories,name', 'min:3', 'max:255'])]
    public string $name = '';

    public function save()
    {
        if (! Auth::user()->can('manage', Category::class)) {
            abort(403);
        }

        // Still needed even though the docs say it runs automatically
        $this->validate();

        Category::create(
            $this->only(['name'])
        );

        return redirect()->route('categories.index')
            ->with('status', 'Category ' . $this->name . ' created.');
    }

    #[Layout('layouts.dashboard')]
    public function render(): View
    {
        return view('livewire.categories.create-category');
    }
}
