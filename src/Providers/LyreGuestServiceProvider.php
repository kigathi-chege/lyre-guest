<?php

namespace Lyre\Guest\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LyreGuestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        register_repositories($this->app, 'Lyre\\Guest\\Repositories', 'Lyre\\Guest\\Contracts');
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \Lyre\Guest\Listeners\LoginListener::class
        );

        register_global_observers("Lyre\\Guest\\Models");

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);

        // $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
