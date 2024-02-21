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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_id');
            $table->unsignedBigInteger('Product_id')->nullable(); // I
            $table->unsignedBigInteger('rent_id')->nullable(); // R
            $table->enum('from', ['items', 'rent', 'custom']);
            $table->string('name')->nullable(); // C
            $table->integer('quantity')->nullable(); // I, R
            $table->double('unit_price')->nullable(); // I
            $table->double('total_price'); // C & {unit_price * quantity}
            $table->enum('type', ['rent', 'sale', 'eol'])->nullable();
            $table->enum('status', ['ready', 'preparing'])->nullable();
            $table->timestamps();

            $table->foreign('party_id')
                ->references('id')
                ->on('parties');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('rent_id')
                ->references('id')
                ->on('rents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
