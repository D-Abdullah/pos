<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()
                ->constrained('products')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('party_id')->nullable()
                ->constrained('parties')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->integer('quantity')->nullable()->default(0);
            $table->enum('type', ['rent', 'sale'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_parties');
    }
};
