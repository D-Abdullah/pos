<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']);
            $table->string('description')->nullable();
            $table->string('amount')->nullable();
            $table->foreignId('party_id')->nullable()
                ->constrained('parties')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('financial_transaction_type_id')->nullable()
                ->constrained('financial_transaction_types')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->enum('from', ['custody', 'safe']);
            $table->foreignId('employee_id')->nullable()
                ->constrained('employees')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('safe_id')->nullable()
                ->constrained('safes')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('added_by')->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
