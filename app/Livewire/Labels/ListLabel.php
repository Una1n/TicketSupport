<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListLabel extends Component
{
    use Toast;
    use WithPagination;

    public array $headers = [];
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function mount()
    {
        $this->headers = [
            ['key' => 'name', 'label' => 'Name']
        ];
    }

    public function createLabel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.create');
    }

    public function editLabel(Label $label): Redirector|RedirectResponse
    {
        return redirect()->route('labels.edit', $label);
    }

    public function deleteLabel(Label $label): void
    {
        $this->authorize('manage', $label);

        $name = $label->name;

        $label->tickets()->detach();

        if ($label->delete()) {
            $this->success('Label ' . $name . ' deleted!');
        } else {
            $this->error('Label ' . $name . ' deletion failed!');
        }
    }

    public function render(): View
    {
        return view('livewire.labels.list-label', [
            'labels' => Label::orderBy(...array_values($this->sortBy))->paginate(10),
        ]);
    }
}
