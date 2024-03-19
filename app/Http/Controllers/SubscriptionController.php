<?php

namespace App\Http\Controllers;

use App\Jobs\CallbackWorker;
use App\Jobs\SubscriptionCheckerJob;
use App\Models\CallbackUrl;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function purchase(Request $request){
        $request->validate([
            'client_token' => 'required|exists:devices,client_token',
            'receipt' => 'required|string',
        ]);

        $device = Device::where('client_token', $request->client_token)->first();
        if($device){
            $subscription = Subscription::where('device_id', $device->id)->first();
            if($subscription){
                $subscription->load('app', 'device');
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

                $subscription->load('app', 'device');

                CallbackWorker::dispatch('started', $subscription);

                return response()->json(['message' => 'Purchase authorized', 'subscription' => $subscription], 200);
            }else{
                return response()->json(['message' => 'Purchase not authorized'], 400);
            }
        }

        return response()->json(['message' => 'Device not found'], 404);
    }

    public function checkStatus(Request $request){
        $request->validate([
            'client_token' => 'required|exists:devices,client_token',
        ]);

        $device = Device::where('client_token', $request->client_token)->first();

        $subscription = $device->subscriptions->where('app_id', $device->app_id)->first();

        if($subscription->isExpired()){
            return response()->json(['message' => 'Subscription expired', 'subscription' => $subscription], 400);
        }

        return response()->json(['message' => 'Subscription active', 'subscription' => $subscription], 200);
    }

    public function getSubscriptionReport()
    {
        $subscriptions = DB::table('subscriptions')
            ->join('devices', 'subscriptions.device_id', '=', 'devices.id')
            ->join('apps', 'subscriptions.app_id', '=', 'apps.id')
            ->select(
                'apps.name as app_name',
                'devices.operating_system',
                DB::raw('DATE(subscriptions.created_at) as day'),
                DB::raw('SUM(CASE WHEN subscriptions.status = "active" THEN 1 ELSE 0 END) as started'),
                DB::raw('SUM(CASE WHEN subscriptions.status = "expired" THEN 1 ELSE 0 END) as ended'),
                DB::raw('SUM(CASE WHEN subscriptions.status = "cancelled" THEN 1 ELSE 0 END) as renewed')
            )
            ->groupBy('app_name', 'operating_system', 'day')
            ->get();

        return response()->json($subscriptions);
    }
}
