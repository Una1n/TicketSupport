<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class CreateCategory extends Component
{
    use Toast;

    public CategoryForm $form;

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.index');
    }

    public function save(): void
    {
        $this->authorize('manage', Category::class);

        $this->form->store();

        $this->success(
            'Category ' . $this->form->name . ' created!',
            redirectTo: route('categories.index')
        );
    }

    public function render(): View
    {
        return view('livewire.categories.create-category');
    }
}
