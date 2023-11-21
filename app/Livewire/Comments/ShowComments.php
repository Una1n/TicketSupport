<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class ShowComments extends Component
{
    public Ticket $ticket;

    #[Validate(['required', 'string', 'min:3', 'max:512'], as: 'message')]
    public string $newComment;

    public function save(): Redirector|RedirectResponse
    {
        $this->authorize('add comments', Comment::class);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        Comment::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->user()->id,
            'message' => $this->newComment,
        ]);

        return redirect()->route('tickets.show', $this->ticket)
            ->with('status', 'Comment created.');
    }

    public function render(): View
    {
        $comments = Comment::query()
            ->with('user')
            ->where('ticket_id', '=', $this->ticket->id)
            ->latest()
            ->get();

        return view('livewire.comments.show-comments', [
            'comments' => $comments,
        ]);
    }
}
