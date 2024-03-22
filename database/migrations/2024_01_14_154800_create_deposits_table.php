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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->double('cost');
            $table->date('date');
            $table->enum('type', ['purchase', 'party']);
            $table->timestamps();

            $table->foreignId('purchase_id')->nullable()
            ->constrained('purchases')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('party_id')->nullable()
            ->constrained('parties')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
