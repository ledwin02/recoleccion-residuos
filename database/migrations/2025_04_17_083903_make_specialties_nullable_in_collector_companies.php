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
        Schema::table('collector_companies', function (Blueprint $table) {
            if (!Schema::hasColumn('collector_companies', 'address')) {
                $table->string('address')->nullable();
            }

            if (!Schema::hasColumn('collector_companies', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('collector_companies', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('collector_companies', 'website')) {
                $table->string('website')->nullable();
            }

            if (!Schema::hasColumn('collector_companies', 'specialties')) {
                $table->string('specialties')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collector_companies', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'email', 'website', 'specialties']);
        });
    }
};
