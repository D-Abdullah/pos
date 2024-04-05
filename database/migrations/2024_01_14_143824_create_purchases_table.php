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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('quantity');
            $table->double('total_price');
            $table->double('unit_price');
            $table->timestamps();

            $table->foreignId('added_by')->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('product_id')->nullable()
                ->constrained('products')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreignId('supplier_id')->nullable()
                ->constrained('suppliers')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
