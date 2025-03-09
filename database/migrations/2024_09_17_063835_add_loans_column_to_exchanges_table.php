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
        Schema::table('exchanges', function (Blueprint $table) {
            $table->decimal('association_loan', 10, 2)->default(0)->comment('قرض الجمعية');
            $table->decimal('savings_loan', 10, 2)->default(0)->comment('قرض إدخار');
            $table->decimal('shekel_loan', 10, 2)->default(0)->comment('قرض شيكل');
            $table->enum('exchange_type', ['receivables_discount','savings_discount','savings_loan', 'shekel_loan', 'association_loan','reward'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exchanges', function (Blueprint $table) {
            $table->dropColumn(['association_loan', 'savings_loan', 'shekel_loan']);
        });
    }
};
