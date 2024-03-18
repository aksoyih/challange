<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CallbackWorker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const EVENTS = [
        'started' => 'App\Jobs\Callbacks\StartedEventJob',
        'renewed' => 'App\Jobs\Callbacks\RenewedEventJob',
        'cancelled' => 'App\Jobs\Callbacks\CancelledEventJob',
    ];

    private $event;
    private $subscription;
    /**
     * Create a new job instance.
     */
    public function __construct($event, $subscription)
    {
        $this->event = $event;
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $job = self::EVENTS[$this->event];
        dispatch(new $job($this->subscription));
    }
}
