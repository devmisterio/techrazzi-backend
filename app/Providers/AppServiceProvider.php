<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\EventRepository;
use App\Services\CommentService;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EventService::class, function () {
            return new EventService(new EventRepository());
        });
        $this->app->singleton(CommentService::class, function () {
            return new CommentService(new CommentRepository());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('tr');

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
