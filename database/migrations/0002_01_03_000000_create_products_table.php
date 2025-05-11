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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);

            $table->integer('material_cost')->nullable()->default(null);
            $table->integer('process_cost')->nullable()->default(null);
            $table->integer('aux_cost')->nullable()->default(null);
            $table->integer('attach_cost')->nullable()->default(null);
            $table->integer('cost_total')->nullable()->default(null);
            $table->float('rate')->nullable()->default(env('RATE_DEFAULT', 0.6));
            $table->float('raw_price')->nullable()->default(null);
            $table->float('net_rate')->nullable()->default(env('NET_RATE_DEFAULT', 0.65));
            $table->integer('price')->nullable()->default(null);


            $table->integer('quantity')->nullable()->default(null);
            $table->string('unit')->nullable()->default(null);
            $table->integer('total')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
