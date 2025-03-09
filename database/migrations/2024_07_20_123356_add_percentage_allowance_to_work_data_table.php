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
        Schema::table('work_data', function (Blueprint $table) {
            $table->smallInteger('percentage_allowance')->nullable()->default(0)->comment('نسبة العلاوة من طبيعة العمل')->after('field_action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_data', function (Blueprint $table) {
            $table->dropColumn('percentage_allowance');
        });
    }
};
