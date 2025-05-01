<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class CreateLabel extends Component
{
    use Toast;

    #[Validate(['required', 'unique:labels,name', 'min:3', 'max:255'])]
    public string $name = '';

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.index');
    }

    public function save(): void
    {
        $this->authorize('manage', Label::class);

        $this->validate();

        Label::create(
            $this->only(['name'])
        );

        $this->success('Label ' . $this->name . ' created!', redirectTo: route('labels.index'));
    }

    public function render(): View
    {
        return view('livewire.labels.create-label');
    }
}
