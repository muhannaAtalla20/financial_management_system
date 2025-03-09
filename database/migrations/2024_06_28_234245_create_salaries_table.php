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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('month');
            $table->smallInteger('percentage_allowance')->default(0)->comment('نسبة العلاوة من طبيعة العمل');
            $table->smallInteger('grade_Allowance')->default(0)->comment('علاوة درجة');
            $table->decimal('initial_salary', 10, 2)->default(0)->comment('الراتب الأولي');
            $table->decimal('secondary_salary', 10, 2)->default(0)->comment('الراتب الثانوي');
            $table->integer('allowance_boys')->default(0)->comment('علاوة الأولاد');
            $table->integer('nature_work_increase')->default(0)->comment('إضافة حسب طبيعة العمل');
            $table->decimal('termination_service', 10, 2)->default(0)->comment('نهاية الخدمة');
            $table->decimal('z_Income', 10, 2)->default(0)->comment('ضريبة دخل');
            $table->decimal('gross_salary', 10, 2)->default(0)->comment('إجمالي الراتب');
            $table->decimal('late_receivables', 10, 2)->default(0)->comment('مستحقات متأخرة');
            $table->decimal('total_discounts', 10, 2)->default(0)->comment('إجمالي الخصومات');
            $table->integer('net_salary')->default(0)->comment('صافي الراتب');
            $table->string('amount_letters')->comment('المبلغ بالحروف');
            $table->string('bank')->comment('البنك');
            $table->string('branch_number')->comment('رقم الفرع');
            $table->string('account_number')->comment('رقم الحساب');
            $table->string('resident_exemption')->default(0)->comment('إعفاء مقيم');
            $table->decimal('annual_taxable_amount', 10, 2)->default(0)->comment('مبلغ الضريبة الخاضع السنوي');
            $table->decimal('tax', 10, 2)->default(0)->comment('الضريبة');
            $table->decimal('exemptions', 10, 2)->default(0)->comment('الإعفائات');
            $table->decimal('amount_tax', 10, 2)->default(0)->comment('مبلغ ضريبة');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['employee_id','month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
