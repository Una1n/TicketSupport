<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class EditCategory extends Component
{
    public Category $category;
    public string $name = '';

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('categories')->ignore($this->category),
                'min:3',
                'max:255',
            ],
        ];
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', $this->category);

        $this->validate();

        $this->category->update([
            'name' => $this->name,
        ]);

        return redirect()->route('categories.index')
            ->with('status', 'Category ' . $this->name . ' updated.');
    }

    public function render(): View
    {
        return view('livewire.categories.edit-category');
    }
}
