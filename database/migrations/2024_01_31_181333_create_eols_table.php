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
            $table->integer('quantity');
            $table->text('reason');
            $table->timestamps();

            $table->foreignId('product_id')
            ->constrained('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');

                $table->foreignId('added_by')
            ->constrained('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
