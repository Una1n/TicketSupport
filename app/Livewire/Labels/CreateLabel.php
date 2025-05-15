<?php

namespace App\Livewire\Labels;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class CreateLabel extends Component
{
    use Toast;

    public LabelForm $form;

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.index');
    }

    public function save(): void
    {
        $this->authorize('manage', Label::class);

        $this->form->store();

        $this->success(
            'Label ' . $this->form->name . ' created!',
            redirectTo: route('labels.index')
        );
    }

    public function render(): View
    {
        return view('livewire.labels.create-label');
    }
}
