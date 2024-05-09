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
        Schema::table('warehouse_transactions', function (Blueprint $table) {
            $table->enum('type', ['purchases', 'eol', 'rent', 'party_sale', 'party_eol', 'party_rent_i', 'party_rent_o'])->nullable(true)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_transactions', function (Blueprint $table) {
            $table->enum('type', ['purchases', 'party_sale', 'party_eol', 'party_rent', 'eol', 'rent'])->nullable(true)->default(null)->change();
        });
    }
};
