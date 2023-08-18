<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory;
    use LogsActivity;
    use InteractsWithMedia;

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

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeOpen(Builder $query): void
    {
        $query->where('status', '=', 'open');
    }

    public function scopeClosed(Builder $query): void
    {
        $query->where('status', '=', 'closed');
    }

    public function scopeAssignedToAgent(Builder $query, User $user): void
    {
        $query->where('agent_id', '=', $user->id);
    }

    public function scopeByUser(Builder $query, User $user): void
    {
        $query->where('user_id', '=', $user->id);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('priority', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhereHas('user', function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('categories', function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('labels', function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'priority', 'description', 'status', 'agent.name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
