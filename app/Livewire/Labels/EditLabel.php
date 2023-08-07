<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditLabel extends Component
{
    public Label $label;
    public string $name = '';

    public function mount(Label $label): void
    {
        $this->label = $label;
        $this->name = $label->name;
    }

    // Unique with exception doesn't work as Rule Attribute
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'unique:labels,name,' . $this->label->id,
                'min:3',
                'max:255',
            ],
        ];
    }

    public function save()
    {
        if (! Auth::user()->can('manage', Label::class)) {
            abort(403);
        }

        // Still needed even though the docs say it runs automatically
        $this->validate();

        $this->label->update([
            'name' => $this->name,
        ]);

        return redirect()->route('labels.index')
            ->with('status', 'Label ' . $this->name . ' updated.');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.labels.edit-label');
    }
}
