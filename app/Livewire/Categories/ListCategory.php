<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListCategory extends Component
{
    public Collection $categories;

    public function mount(): void
    {
        $this->categories = Category::orderBy('name')->get();
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.categories.list-category');
    }
}
