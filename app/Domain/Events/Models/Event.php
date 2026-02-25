<?php

declare(strict_types=1);

namespace App\Domain\Events\Models;

use App\Domain\Categories\Models\Category;
use App\Domain\Sessions\Models\Session;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Venues\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'contact_phone',
        'contact_email',
        'twitter_url',
        'logo_url',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
