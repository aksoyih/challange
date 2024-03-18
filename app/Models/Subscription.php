<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'app_id',
        'device_id',
        'token',
        'status',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
