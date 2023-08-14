<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateLabel extends Component
{
    #[Rule(['required', 'unique:labels,name', 'min:3', 'max:255'])]
    public string $name = '';

    public function save()
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

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.labels.create-label');
    }
}
