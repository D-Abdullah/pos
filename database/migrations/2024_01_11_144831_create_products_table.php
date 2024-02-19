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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->unsignedBigInteger('department_id');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('department_id')
            ->references('id')
            ->on('departments');

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
        Schema::dropIfExists('products');
    }
};
