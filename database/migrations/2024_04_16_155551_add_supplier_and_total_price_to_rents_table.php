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
            $table->double('total_price', 10, 2)->after('quantity');
            $table->foreignId('supplier_id')->nullable()
                ->constrained('suppliers')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->dropForeign('rents_supplier_id_foreign');
            $table->dropColumn('supplier_id');
            $table->dropColumn('total_price');
        });
    }
};
