<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BeyondCode\Mailbox\Facades\Mailbox;
use App\Workers\MailboxWorker;

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
        Mailbox::fallback(MailboxWorker::class);
    }
}
