<?php

namespace App\Jobs\Callbacks;

use App\Models\CallbackUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CancelledEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $subscription;
    /**
     * Create a new job instance.
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = CallbackUrl::where('event', 'cancelled')->first()->url;
        // send curl request to $url

        $response = Http::post($url, [
            'subscription_id' => $this->subscription->id,
            'app_id' => $this->subscription->app_id,
            'event' => 'cancelled',
        ]);

        $status = $response->status();
        if($status !== 200 || $status !== 201) {
            $this->release(60);
        }
    }
}
