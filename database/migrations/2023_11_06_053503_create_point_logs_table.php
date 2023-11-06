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
        Schema::create('point_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_id')->constrained();
            $table->foreignId('point_status_id')->constrained();
            $table->integer('amount');
            $table->string('actor_id');
            $table->string('actor_name');
            $table->foreignId('receipt_id')->nullable()->constrained();
            $table->foreignId('reward_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_logs');
    }
};
