<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class EditLabel extends Component
{
    use Toast;

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
                Rule::unique('labels')->ignore($this->label),
                'min:3',
                'max:255',
            ],
        ];
    }

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.index');
    }

    public function save(): void
    {
        $this->authorize('manage', $this->label);

        $this->validate();
        $oldName = $this->label->name;

        $this->label->update([
            'name' => $this->name,
        ]);

        $this->success(
            'Label ' . $this->name . ' updated!',
            description: $oldName . ' -> ' . $this->name,
            redirectTo: route('labels.index')
        );
    }

    public function render(): View
    {
        return view('livewire.labels.edit-label');
    }
}
