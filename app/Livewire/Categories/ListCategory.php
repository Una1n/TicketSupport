<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListCategory extends Component
{
    use Toast;
    use WithPagination;

    public bool $editModal = false;
    public ?Category $editCategory = null;
    public array $headers = [];
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function mount()
    {
        $this->headers = [
            ['key' => 'name', 'label' => 'Name']
        ];
    }

    public function openEditModal(Category $category)
    {
        $this->editCategory = $category;
        $this->editModal = true;
    }

    #[On('cancel')]
    public function closeEditModal()
    {
        $this->editModal = false;
        $this->editCategory = null;
    }

    public function createCategory(): Redirector|RedirectResponse
    {
        return redirect()->route('categories.create');
    }

    public function deleteCategory(Category $category): void
    {
        $this->authorize('manage', $category);

        $name = $category->name;

        // Remove category from tickets
        $category->tickets()->detach();

        if ($category->delete()) {
            $this->success('Category ' . $name . ' deleted!');
        } else {
            $this->error('Category ' . $name . ' deletion failed!');
        }
    }

    public function render(): View
    {
        return view('livewire.categories.list-category', [
            'categories' => Category::orderBy(...array_values($this->sortBy))->paginate(10),
        ]);
    }
}
