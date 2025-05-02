<?php

namespace App\Livewire\Labels;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class EditLabel extends Component
{
    use Toast;

    public LabelForm $form;

    public function mount(Label $label): void
    {
        $this->form->setLabel($label);
    }

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.index');
    }

    public function save(): void
    {
        $this->authorize('manage', $this->form->label);

        $oldName = $this->form->label->name;
        $this->form->update();

        $this->success(
            'Label ' . $this->form->name . ' updated!',
            description: $oldName . ' -> ' . $this->form->name,
            redirectTo: route('labels.index')
        );
    }

    public function render(): View
    {
        return view('livewire.labels.edit-label');
    }
}
