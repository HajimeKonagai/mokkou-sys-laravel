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
        Schema::create('estimate_product_materials', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('estimate_product_id')->nullable()->default(null);

            $table->integer('seq')->default(0);
            $table->unsignedBigInteger('material_id')->nullable()->default(null);
            $table->string('code')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('quantity')->nullable()->default(null);
            $table->string('unit')->nullable()->default(null);
            $table->string('price')->nullable()->default(null);
            $table->integer('total')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_product_materials');
    }
};
