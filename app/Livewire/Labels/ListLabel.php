<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListLabel extends Component
{
    use WithPagination;

    public function deleteLabel(Label $label): void
    {
        if (! Auth::user()->can('manage', Label::class)) {
            abort(403);
        }

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
