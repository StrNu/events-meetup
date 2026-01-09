<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Domain\Categories\Repositories\CategoryRepository;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EventRepository::class);
        $this->app->singleton(SpeakerRepository::class);
        $this->app->singleton(SessionRepository::class);
        $this->app->singleton(RoomRepository::class);
        $this->app->singleton(CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
