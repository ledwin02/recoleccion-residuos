<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->enum('role', ['admin', 'collector', 'user'])->default('user');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role']);
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};
