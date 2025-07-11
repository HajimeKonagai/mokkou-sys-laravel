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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('staff')->nullable()->default(null);

            $table->string('deadline')->nullable()->default(null);
            $table->string('condition')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->string('expiration')->nullable()->default(null);

            $table->float('net_rate')->nullable()->default(env('NET_RATE_DEFAULT', 0.65));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
