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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->default(null);

            $table->integer('seq')->default(0);
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->string('code')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('quantity')->nullable()->default(null);
            $table->string('unit')->nullable()->default(null);
            $table->string('price')->nullable()->default(null);

            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->string('user_name')->nullable()->default(null);
            $table->date('deadline')->nullable()->default(null);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
