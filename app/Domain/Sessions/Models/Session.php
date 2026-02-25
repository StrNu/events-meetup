<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Models;

use App\Domain\Categories\Models\Category;
use App\Domain\Events\Models\Event;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Users\Models\User;
use App\Domain\Venues\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    protected $fillable = [
        'event_id',
        'room_id',
        'category_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'session_speaker')
            ->withPivot('role');
    }

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_sessions')
            ->withPivot('notify')
            ->withTimestamps();
    }
}
