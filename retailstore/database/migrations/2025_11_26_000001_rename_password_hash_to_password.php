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
        Schema::table('customers', function (Blueprint $table) {
            // Drop the old column and create new one
            // MariaDB doesn't support renameColumn, so we drop and recreate
            $table->dropColumn('password_hash');
            $table->string('password', 255)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->string('password_hash', 255)->after('email');
        });
    }
};
