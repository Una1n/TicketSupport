<?php

namespace App\Livewire\Labels;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListLabel extends Component
{
    use Toast;
    use WithPagination;

    public bool $editModal = false;
    public ?Label $editLabel = null;
    public array $headers = [];
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function mount()
    {
        $this->headers = [
            ['key' => 'name', 'label' => 'Name']
        ];
    }

    public function openEditModal(Label $label)
    {
        $this->editLabel = $label;
        $this->editModal = true;
    }

    #[On('cancel')]
    public function closeEditModal()
    {
        $this->editModal = false;
        $this->editLabel = null;
    }

    public function createLabel(): Redirector|RedirectResponse
    {
        return redirect()->route('labels.create');
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
