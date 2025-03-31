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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->default(null);
            $table->date('estimated_at')->nullable()->default(null);

            $table->string('deadline')->nullable()->default(null);
            $table->string('condition')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->string('expiration')->nullable()->default(null);

            $table->integer('total')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
