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
        Schema::create('eols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('added_by');
            $table->integer('quantity');
            $table->text('reason');
            $table->timestamps();


            $table->foreign('product_id')
        ->references('id')
        ->on('products');

        $table->foreign('added_by')
        ->references('id')
        ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eols');
    }
};
