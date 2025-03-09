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
        Schema::table('salaries', function (Blueprint $table) {
            $table->string('savings_loan')->default(0);
            $table->string('shekel_loan')->default(0);
            $table->string('association_loan')->default(0);
            $table->string('savings_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropColumn(['savings_loan', 'shekel_loan', 'association_loan', 'late_receivables', 'savings_rate', 'termination_service']);
        });
    }
};
