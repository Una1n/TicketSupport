<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Mary\Traits\Toast;

class EditCategory extends Component
{
    use Toast;

    public CategoryForm $form;

    public function mount(Category $category): void
    {
        $this->form->setCategory($category);
    }

    public function cancel(): void
    {
        $this->dispatch('cancel')->to(ListCategory::class);
    }

    public function save(): void
    {
        $this->authorize('manage', $this->form->category);

        $oldName = $this->form->category->name;
        $this->form->update();

        $this->success(
            'Category ' . $this->form->name . ' updated!',
            description: $oldName . ' -> ' . $this->form->name,
        );

        $this->cancel();
    }

    public function render(): View
    {
        return view('livewire.categories.edit-category');
    }
}
