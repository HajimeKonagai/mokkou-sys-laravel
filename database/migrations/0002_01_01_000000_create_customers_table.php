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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->string('zip')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('tel')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->string('close_date')->nullable()->default(null);
            $table->string('pay_date')->nullable()->default(null);
            $table->string('pay_way')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
