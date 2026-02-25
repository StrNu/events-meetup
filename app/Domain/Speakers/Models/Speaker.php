<?php

declare(strict_types=1);

namespace App\Domain\Speakers\Models;

use App\Domain\Events\Models\Event;
use App\Domain\Sessions\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Speaker extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'title',
        'organization',
        'bio',
        'photo_url',
        'social_links',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_speaker')
            ->withPivot('role');
    }
}
