<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use App\Models\Ticket;
use Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ShowComments extends Component
{
    public Ticket $ticket;

    #[Rule(['required', 'string', 'min:3', 'max:512'], as: 'message')]
    public string $newComment;

    public function save()
    {
        $this->authorize('add comments', Comment::class);

        // Still needed even though the docs say it runs automatically
        $this->validate();

        Comment::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => Auth::user()->id,
            'message' => $this->newComment,
        ]);

        return redirect()->route('tickets.show', $this->ticket)
            ->with('status', 'Comment created.');
    }

    public function render()
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
