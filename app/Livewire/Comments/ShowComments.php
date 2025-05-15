<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowComments extends Component
{
    use Toast;

    // Current Ticket
    public Ticket $ticket;

    #[Validate(['required', 'string', 'min:3', 'max:512'], as: 'message')]
    public string $newComment;

    public function save(): void
    {
        $this->authorize('add comments', Comment::class);

        $this->validate();

        $this->ticket->comments()->create([
            'user_id' => auth()->user()->id,
            'message' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->success('New Comment Added!');
    }

    public function render(): View
    {
        $comments = $this->ticket->comments()
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.comments.show-comments', [
            'comments' => $comments,
        ]);
    }
}
