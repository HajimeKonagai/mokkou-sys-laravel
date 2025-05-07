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
        Schema::create('task_materials', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('task_id')->nullable()->default(null);
            $table->unsignedBigInteger('material_id')->nullable()->default(null);

            $table->integer('seq')->default(0);
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
        Schema::dropIfExists('task_materials');
    }
};
