<?php

namespace App\Livewire\Forms;

use App\Models\Label;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LabelForm extends Form
{
    public ?Label $label = null;

    public string $name = '';

    public function setLabel(Label $label): void
    {
        $this->label = $label;
        $this->name = $label->name;
    }

    /**
     * @return array<string, array<string>>
     */
    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('labels')->ignore($this->label),
                'min:3',
                'max:255',
            ],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->label->update(
            $this->only('name')
        );
    }

    public function store()
    {
        $this->validate();

        Label::create($this->only('name'));
    }
}
