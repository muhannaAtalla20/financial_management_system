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
        Schema::create('fixed_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('month');
            $table->decimal('administrative_allowance', 10, 2)->default(0)->comment('علاوة إدارية');
            $table->decimal('scientific_qualification_allowance', 10, 2)->default(0)->comment('علاوة مؤهل علمي');
            $table->decimal('transport', 10, 2)->default(0)->comment('مواصلات');
            $table->decimal('extra_allowance', 10, 2)->default(0)->comment('بدل إضافي');
            $table->decimal('salary_allowance', 10, 2)->default(0)->comment('علاوة اغراض راتب');
            $table->decimal('ex_addition', 10, 2)->default(0)->comment('إضافة بأثر رجعي');
            $table->decimal('mobile_allowance', 10, 2)->default(0)->comment('علاوة جوال');
            $table->decimal('health_insurance', 10, 2)->default(0)->comment('تأمين صحي');
            $table->decimal('f_Oredo', 10, 2)->default(0)->comment('فاتورة الوطنية');
            $table->decimal('association_loan', 10, 2)->default(0)->comment('قرض الجمعية');
            $table->decimal('tuition_fees', 10, 2)->default(0)->comment('رسوم دراسية');
            $table->decimal('voluntary_contributions', 10, 2)->default(0)->comment('تبرعات');
            $table->decimal('savings_loan', 10, 2)->default(0)->comment('قرض إدخار');
            $table->decimal('shekel_loan', 10, 2)->default(0)->comment('قرض شيكل');
            $table->decimal('paradise_discount', 10, 2)->default(0)->comment('خصم اللجنة');
            $table->decimal('other_discounts', 10, 2)->default(0)->comment('خصومات أخرى');
            $table->decimal('proportion_voluntary', 10, 2)->default(0)->comment('تبرعات للحركة');
            $table->decimal('savings_5', 10, 2)->default(0.0)->comment('إدخار 5%');
            $table->unique(['employee_id','month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_entries');
    }
};
