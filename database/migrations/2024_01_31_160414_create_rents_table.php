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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('rent_price');
            $table->double('sale_price');
            $table->integer('quantity');
            $table->boolean('is_active');
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')
            ->references('id')
            ->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
