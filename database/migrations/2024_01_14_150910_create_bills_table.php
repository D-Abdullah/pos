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
            $table->enum('from', ['items', 'rent', 'custom']);
            $table->string('name')->nullable(); // C
            $table->integer('quantity')->nullable(); // I, R
            $table->double('unit_price')->nullable(); // I
            $table->double('total_price'); // C & {unit_price * quantity}
            $table->enum('type', ['rent', 'sale', 'eol'])->nullable();
            $table->enum('status', ['ready', 'preparing'])->nullable();
            $table->timestamps();

           
                $table->foreignId('party_id')

            ->constrained('parties')
            ->onDelete('cascade')
            ->onUpdate('cascade');

                $table->foreignId('product_id')->nullable()
            ->constrained('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');

                $table->foreignId('rent_id')->nullable()
            ->constrained('rents')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
