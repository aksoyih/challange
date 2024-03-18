<?php

namespace App\Jobs;

use App\Http\Controllers\MockController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubscriptionCheckerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscription;
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
        $authorize_response = (new MockController)->authorizePurchase(
            $this->subscription->device->operating_system,
            $this->subscription->receipt
        );
        if($authorize_response->status() === 200){
            $this->subscription->expire_date = $authorize_response['expire-date'];
            $this->subscription->save();
        }elseif($authorize_response->status() === 400){
            $this->subscription->status = 'expired';
            $this->subscription->save();
        }else{ // probably rate limit http:429
            $this->release(60);
        }
    }
}
