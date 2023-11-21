<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateLabel extends Component
{
    #[Validate(['required', 'unique:labels,name', 'min:3', 'max:255'])]
    public string $name = '';

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('manage', Label::class);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        Label::create(
            $this->only(['name'])
        );

        return redirect()->route('labels.index')
            ->with('status', 'Label ' . $this->name . ' created.');
    }

    public function render(): View
    {
        return view('livewire.labels.create-label');
    }
}
