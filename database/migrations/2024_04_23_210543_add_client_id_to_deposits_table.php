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
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign('deposits_party_id_foreign');
            $table->dropColumn('party_id');
            $table->foreignId('client_id')
                ->after('supplier_id')
                ->nullable()
                ->constrained('clients')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->foreignId('party_id')->nullable()
                ->constrained('parties')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->dropForeign('deposits_client_id_foreign');
            $table->dropColumn('client_id');
        });
    }
};
