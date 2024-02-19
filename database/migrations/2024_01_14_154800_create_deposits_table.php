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
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->double('cost');
            $table->date('date');
            $table->enum('type', ['purchase', 'bill']);
            $table->timestamps();

            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases');

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills');
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
