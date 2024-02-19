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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('added_by');
            $table->string('name');
            $table->string('address');
            $table->date('data');
            $table->enum('status',['contracted', 'transported', 'completed']);
            $table->timestamps();

            $table->foreign('added_by')
            ->references('id')
            ->on('users');

            $table->foreign('client_id')
            ->references('id')
            ->on('clients');




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
