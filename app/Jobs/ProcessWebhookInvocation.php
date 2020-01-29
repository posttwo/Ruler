<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\WebhookInvocation;
use App\Enums\WebhookInvocationStatus;

class ProcessWebhookInvocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invocation;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookInvocation $invocation)
    {
        $this->invocation = $invocation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->invocation->status = WebhookInvocationStatus::WORKING;
        $this->invocation->save();

        $type = $this->invocation->webhook->type;
        $handler = app('App\Workers\Webhook\\' . $type);
        $handler->invoke($this->invocation);

        $this->invocation->status = WebhookInvocationStatus::COMPLETED;
        $this->invocation->save();

    }

    public function failed()
    {
        $this->invocation->status = WebhookInvocationStatus::FAILED;
        $this->invocation->save();
    }
}
