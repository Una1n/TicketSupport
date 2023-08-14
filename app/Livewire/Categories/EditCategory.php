<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditCategory extends Component
{
    public Category $category;
    public string $name = '';

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    // Unique with exception doesn't work as Rule Attribute
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'unique:categories,name,' . $this->category->id,
                'min:3',
                'max:255',
            ],
        ];
    }

    public function save()
    {
        $this->authorize('manage', $this->category);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        $this->category->update([
            'name' => $this->name,
        ]);

        return redirect()->route('categories.index')
            ->with('status', 'Category ' . $this->name . ' updated.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.categories.edit-category');
    }
}
