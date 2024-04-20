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
            $table->enum('from', ['custody', 'safe']);
            $table->foreignId('employee_id')->nullable()
                ->constrained('employees')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('safe_id')->nullable()
                ->constrained('safes')
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
            $table->dropForeign('deposits_employee_id_foreign');
            $table->dropForeign('deposits_safe_id_foreign');
            $table->dropColumn('employee_id');
            $table->dropColumn('safe_id');
            $table->dropColumn('from');
        });
    }
};
