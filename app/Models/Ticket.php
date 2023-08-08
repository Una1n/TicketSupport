<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    /** Fillables */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'agent_id',
        'user_id',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOpen(Builder $query): void
    {
        $query->where('status', '=', 'open');
    }

    public function scopeClosed(Builder $query): void
    {
        $query->where('status', '=', 'closed');
    }

    public function scopeAgent(Builder $query, User $user): void
    {
        $query->where('agent_id', '=', $user->id);
    }

    public function scopeByUser(Builder $query, User $user): void
    {
        $query->where('user_id', '=', $user->id);
    }
}
