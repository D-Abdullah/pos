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
            $table->unsignedBigInteger('Product_id')->nullable();
            $table->enum('from',['items','rent','custom']);
            $table->string('name')->nullable();
            $table->integer('quantity');
            $table->double('rent_price')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('total_price');
            $table->enum('type',['rent','sale','eol']);
            $table->enum('status',['ready','preparing']);
            $table->timestamps();


            $table->foreign('party_id')
            ->references('id')
            ->on('parties');

            $table->foreign('product_id')
            ->references('id')
            ->on('products');

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
