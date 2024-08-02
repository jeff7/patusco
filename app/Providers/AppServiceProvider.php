<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\AppointmentRepository;
use App\Models\User;
use App\Models\Appointment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository(new User());
        });
        
        $this->app->bind(AppointmentRepository::class, function ($app) {
            return new AppointmentRepository(new Appointment());
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
