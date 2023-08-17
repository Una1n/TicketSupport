<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class EditLabel extends Component
{
    public Label $label;
    public string $name = '';

    public function mount(Label $label): void
    {
        $this->label = $label;
        $this->name = $label->name;
    }

    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                // Unique with exception doesn't work as Rule Attribute
                'unique:labels,name,' . $this->label->id,
                'min:3',
                'max:255',
            ],
        ];
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', $this->label);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        $this->label->update([
            'name' => $this->name,
        ]);

        return redirect()->route('labels.index')
            ->with('status', 'Label ' . $this->name . ' updated.');
    }

    public function render(): View
    {
        return view('livewire.labels.edit-label');
    }
}
