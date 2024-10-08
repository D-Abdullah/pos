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
            $table->enum('type', ['supplier', 'party']);
            $table->tinyInteger('is_paid')->default(0);
            $table->timestamps();

            $table->foreignId('supplier_id')->nullable()
                ->constrained('suppliers')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('party_id')->nullable()
                ->constrained('parties')
                ->onDelete('set null')
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
