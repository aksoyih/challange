<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'device_uid',
        'client_token',
        'operating_system',
        'language',
        'app_id',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'id',
        'app_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($device) {
            $device->client_token = Str::random(255);
        });
    }
    public function app(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(App::class);
    }

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
