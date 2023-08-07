<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListLabel extends Component
{
    public Collection $labels;

    public function mount(): void
    {
        $this->updateLabels();
    }

    public function deleteLabel(Label $label): void
    {
        if (! Auth::user()->can('manage', Label::class)) {
            abort(403);
        }

        $name = $label->name;

        $label->delete();

        $this->updateLabels();

        session()->flash('status', 'Category ' . $name . ' Deleted!');
    }

    private function updateLabels(): void
    {
        $this->labels = Label::orderBy('name')->get();
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.labels.list-label');
    }
}
