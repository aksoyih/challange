<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'device_uid' => 'required|string|max:255',
                'device_os' => 'required|in:android,ios',
                'app_id' => 'required|exists:apps,id',
                'language' => 'required|string|size:2',
            ]
        );

        $device = Device::where('device_uid', $request->device_uid)->first();
        if($device) {
            $device->load('app');
            return response()->json(
                [
                    'status' => 'register OK',
                    'device' => $device
                ], 200);
        }

        $device = Device::create($request->all());
        return response()->json(
            [
                'status' => 'register OK',
                'device' => $device
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
    }
}
