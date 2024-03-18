<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'app_id',
        'device_id',
        'receipt',
        'expire_date',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function isExpired(): bool
    {
        return now() > $this->expire_date;
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
