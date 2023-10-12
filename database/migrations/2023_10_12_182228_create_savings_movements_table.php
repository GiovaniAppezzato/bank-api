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
        Schema::create('savings_movements', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->enum('type', ['Deposit', 'Withdraw']);
            $table->foreignId('savings_id')->references('id')->on('savings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_movements');
    }
};
