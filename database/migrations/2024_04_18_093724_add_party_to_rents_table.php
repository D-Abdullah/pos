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
        Schema::table('rents', function (Blueprint $table) {
            $table->foreignId('party_id')->nullable()
                ->constrained('parties')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->integer('party_qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->dropForeign('rents_party_id_foreign');
            $table->dropColumn('party_id');
            $table->dropColumn('party_qty');
        });
    }
};
