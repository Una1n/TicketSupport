<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListCategory extends Component
{
    public Collection $categories;

    public function mount(): void
    {
        $this->updateCategories();
    }

    public function deleteCategory(Category $category): void
    {
        if (! Auth::user()->can('manage', Category::class)) {
            abort(403);
        }

        $name = $category->name;

        $category->delete();

        $this->updateCategories();

        session()->flash('status', 'Category ' . $name . ' Deleted!');
    }

    private function updateCategories(): void
    {
        $this->categories = Category::orderBy('name')->get();
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.categories.list-category');
    }
}
