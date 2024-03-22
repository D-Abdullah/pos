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
            $table->string('name');
            $table->string('address');
            $table->date('date');
            $table->enum('status', ['contracted', 'transported', 'completed']);
            $table->timestamps();

            $table->foreignId('added_by')
            ->constrained('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('client_id')
            ->constrained('clients')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
