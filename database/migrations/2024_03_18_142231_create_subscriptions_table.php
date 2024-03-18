<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('app_id')->index();
            $table->foreign('app_id')->references('id')->on('apps');
            $table->unsignedBigInteger('device_id')->index();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->unsignedInteger('receipt');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->dateTime('expire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
