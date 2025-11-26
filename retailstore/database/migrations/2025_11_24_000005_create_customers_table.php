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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id'); // INT AUTO_INCREMENT

            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('date_of_birth');

            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();

            // timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
