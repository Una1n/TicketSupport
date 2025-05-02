<?php

namespace App\Livewire\Labels;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Mary\Traits\Toast;

class EditLabel extends Component
{
    use Toast;

    public LabelForm $form;

    public function mount(Label $label): void
    {
        $this->form->setLabel($label);
    }

    public function cancel(): void
    {
        $this->dispatch('cancel')->to(ListLabel::class);
    }

    public function save(): void
    {
        $this->authorize('manage', $this->form->label);

        $oldName = $this->form->label->name;
        $this->form->update();

        $this->success(
            'Label ' . $this->form->name . ' updated!',
            description: $oldName . ' -> ' . $this->form->name,
        );

        $this->cancel();
    }

    public function render(): View
    {
        return view('livewire.labels.edit-label');
    }
}
