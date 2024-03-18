<?php

namespace App\Http\Controllers;

use App\Jobs\SubscriptionCheckerJob;
use App\Models\Subscription;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function checkSubscriptions(){
        $subscriptions = Subscription::where('status', 'active')->where('expire_date', '<', now())->get();
        foreach($subscriptions as $subscription){
            dispatch(new SubscriptionCheckerJob($subscription));
        }
        return $subscriptions;
    }
}
