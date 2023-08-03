<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeOpen(Builder $query): void
    {
        $query->where('status', '=', 'open');
    }

    public function scopeClosed(Builder $query): void
    {
        $query->where('status', '=', 'closed');
    }
}
