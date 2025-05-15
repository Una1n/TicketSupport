<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Mary\Traits\Toast;

class ShowTicket extends Component
{
    use Toast;

    public Ticket $ticket;

    public function editTicket(Ticket $ticket): Redirector|RedirectResponse
    {
        return redirect()->route('tickets.edit', $ticket);
    }

    public function deleteTicket(Ticket $ticket): void
    {
        $this->authorize('manage', $ticket);

        $title = $ticket->title;

        if ($ticket->delete()) {
            $this->success(
                'Ticket ' . $title . ' deleted!',
                redirectTo: route('tickets.index')
            );
        } else {
            $this->error('Ticket ' . $title . ' deletion failed!');
        }
    }

    public function render(): View
    {
        return view('livewire.tickets.show-ticket');
    }
}
