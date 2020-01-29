<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BeyondCode\Mailbox\Facades\Mailbox;
use App\Workers\MailboxWorker;
use App\WebhookInvocation;
use App\Observers\WebhookInvocationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        WebhookInvocation::observe(WebhookInvocationObserver::class);
    }
}
