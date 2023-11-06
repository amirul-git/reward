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
        Schema::create('receipt_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->string('actor_name');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->string("photo");
            $table->integer('amount');
            $table->integer('point');
            $table->foreignId('receipt_id')->constrained();
            $table->unsignedBigInteger('receipt_status_id');
            $table->string('receipt_status_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_logs');
    }
};
