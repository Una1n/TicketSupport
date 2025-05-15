<?php

namespace App\Livewire\Tickets;

use App\Livewire\Forms\TicketForm;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditTicket extends Component
{
    use Toast;
    use WithFileUploads;

    public TicketForm $form;

    public function mount(Ticket $ticket): void
    {
        $this->form->setTicket($ticket);
    }

    public function cancel(): Redirector|RedirectResponse
    {
        return redirect()->route('tickets.show', $this->form->ticket);
    }

    public function removeAttachment(Media $media): void
    {
        if ($media->delete()) {
            $this->success('Attachment removed.');
        } else {
            $this->error('Attachment failed to remove!');
        }

        $this->form->oldAttachments = $this->form->ticket->getMedia('attachments');
    }

    public function save(): void
    {
        $this->authorize('update', $this->form->ticket);

        $this->form->update();

        $this->success(
            'Ticket ' . $this->form->ticket->title . ' Updated!',
            redirectTo: route('tickets.show', $this->form->ticket)
        );
    }

    public function render(): View
    {
        return view('livewire.tickets.edit-ticket', [
            'categories' => Category::all(),
            'labels' => Label::all(),
            'agents' => User::role('Agent')->get(),
            'priorities' => [
                ['id' => 'low', 'name' => 'Low'],
                ['id' => 'medium', 'name' => 'Medium'],
                ['id' => 'high', 'name' => 'High'],
            ],
            'oldAttachments' => $this->form->oldAttachments,
        ]);
    }
}
