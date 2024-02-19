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
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('added_by');
            $table->date('date');
            $table->integer('quantity');
            $table->double('total_price');

            $table->timestamps();
            $table->foreign('added_by')
            ->references('id')
            ->on('users');

            $table->foreign('product_id')
            ->references('id')
            ->on('products');

            $table->foreign('supplier_id')
            ->references('id')
            ->on('suppliers');
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
