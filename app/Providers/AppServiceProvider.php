<?php

namespace App\Providers;

use App\Application\Services\EventService;
use App\Domain\Repositories\EventRepository;
use App\Domain\Services\EventServiceInterface;
use App\Infrastructure\Persistence\EloquentEventRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventRepository::class, EloquentEventRepository::class);
        $this->app->bind(EventServiceInterface::class, EventService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
