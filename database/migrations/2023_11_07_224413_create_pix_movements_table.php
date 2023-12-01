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
        Schema::create('pix_movements', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->foreignId('sender_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreignId('receiver_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreignId('pix_key_id')->references('id')->on('pix_keys')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pix_movements');
    }
};
