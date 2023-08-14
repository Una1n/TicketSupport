<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListLabel extends Component
{
    use WithPagination;

    public function deleteLabel(Label $label): void
    {
        $this->authorize('manage', $label);

        $name = $label->name;

        $label->delete();

        session()->flash('status', 'Label ' . $name . ' Deleted!');
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        return view('livewire.labels.list-label', [
            'labels' => Label::orderBy('name')->paginate(6),
        ]);
    }
}
