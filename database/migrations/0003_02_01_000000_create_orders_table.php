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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_id')->nullable()->default(null);
            // $table->string('code')->nullable()->default(null);
            // $table->string('name')->nullable()->default(null);
            $table->date('deadline_at')->nullable()->default(null);
            $table->integer('status')->default(0);
            $table->datetime('ordered_at')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
