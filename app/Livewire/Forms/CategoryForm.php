<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Category $category = null;

    public string $name = '';

    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    /**
     * @return array<string, array<string>>
     */
    protected function rules(): array
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

    public function update()
    {
        $this->validate();

        $this->category->update(
            $this->only('name')
        );
    }

    public function store()
    {
        $this->validate();

        Category::create($this->only('name'));
    }
}
