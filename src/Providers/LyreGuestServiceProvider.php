<?php

namespace Lyre\Settings\Providers;

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
        register_global_observers("Lyre\\Guest\\Models");

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
