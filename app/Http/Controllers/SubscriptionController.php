<?php

namespace App\Http\Controllers;

use App\Jobs\SubscriptionCheckerJob;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function purchase(Request $request){
        $request->validate([
            'client_id' => 'required|exists:devices,client_token',
            'receipt' => 'required|string',
        ]);

        $device = Device::where('client_token', $request->client_id)->first();
        if($device){
            $subscription = Subscription::where('device_id', $device->id)->first();
            if($subscription){
                return response()->json(['message' => 'Subscription already exists', 'subscription' => $subscription], 400);
            }

            $authorize_response = (new MockController)->authorizePurchase($device->operating_system, $request->receipt);
            if($authorize_response->status() === 200){
                $subscription = new Subscription;
                $subscription->device_id = $device->id;
                $subscription->app_id = $device->app_id;
                $subscription->receipt = $request->receipt;
                $subscription->expire_date = $authorize_response['expire-date'];
                $subscription->save();

                return response()->json(['message' => 'Purchase authorized', 'subscription' => $subscription], 200);
            }else{
                return response()->json(['message' => 'Purchase not authorized'], 400);
            }
        }

        return response()->json(['message' => 'Device not found'], 404);
    }

    public function checkStatus(Request $request){
        $request->validate([
            'client_id' => 'required|exists:devices,client_token',
        ]);

        $device = Device::where('client_token', $request->client_id)->first()->with('subscriptions')->first();

        $subscription = $device->subscriptions->first();

        if($subscription->isExpired()){
            return response()->json(['message' => 'Subscription expired', 'subscription' => $subscription], 400);
        }

        return response()->json(['message' => 'Subscription active', 'subscription' => $subscription], 200);
    }
}
