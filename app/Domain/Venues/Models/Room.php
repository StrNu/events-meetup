<?php

declare(strict_types=1);

namespace App\Domain\Venues\Models;

use App\Domain\Events\Models\Event;
use App\Domain\Sessions\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'capacity',
        'description',
        'photo_url',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
