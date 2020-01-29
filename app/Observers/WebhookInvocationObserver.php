<?php

namespace App\Observers;

use App\WebhookInvocation;
use App\Enums\WebhookInvocationStatus;
use App\Jobs\ProcessWebhookInvocation;

class WebhookInvocationObserver
{
    /**
     * Handle the webhook invocation "created" event.
     *
     * @param  \App\WebhookInvocation  $webhookInvocation
     * @return void
     */
    public function saved(WebhookInvocation $webhookInvocation)
    {
        if($webhookInvocation->status == WebhookInvocationStatus::ADDED){
            $webhookInvocation->status = WebhookInvocationStatus::QUEUED;
            $webhookInvocation->save();
            ProcessWebhookInvocation::dispatch($webhookInvocation);
        }
    }

    /**
     * Handle the webhook invocation "updated" event.
     *
     * @param  \App\WebhookInvocation  $webhookInvocation
     * @return void
     */
    public function updated(WebhookInvocation $webhookInvocation)
    {
        
    }

    /**
     * Handle the webhook invocation "deleted" event.
     *
     * @param  \App\WebhookInvocation  $webhookInvocation
     * @return void
     */
    public function deleted(WebhookInvocation $webhookInvocation)
    {
        //
    }

    /**
     * Handle the webhook invocation "restored" event.
     *
     * @param  \App\WebhookInvocation  $webhookInvocation
     * @return void
     */
    public function restored(WebhookInvocation $webhookInvocation)
    {
        //
    }

    /**
     * Handle the webhook invocation "force deleted" event.
     *
     * @param  \App\WebhookInvocation  $webhookInvocation
     * @return void
     */
    public function forceDeleted(WebhookInvocation $webhookInvocation)
    {
        //
    }
}
