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
        Schema::create('work_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('working_status')->comment('حالة الدوام');
            $table->string('type_appointment')->comment('نوع التعين');
            $table->string('field_action')->comment('مجال العمل');
            $table->smallInteger('allowance')->nullable()->default(0)->comment('العلاوة في سلم الرواتب');
            $table->string('grade',3)->nullable()->default(10)->comment('الدرجة في سلم الرواتب');
            $table->smallInteger('grade_allowance_ratio')->nullable()->default(0)->comment('نسبة علاوة درجة');
            $table->string('dual_function')->comment('مزدوج الوظيفة')->nullable();
            $table->integer('years_service')->nullable()->comment('سنوات الخدمة');
            $table->string('nature_work')->comment('طبيعة العمل');
            $table->string('state_effectiveness')->comment('حالة الفعالية');
            $table->string('association')->comment('جمعية');
            $table->string('workplace');
            $table->string('section');
            $table->string('dependence')->comment('التبعية');
            $table->date('working_date')->comment('تاريخ العمل');
            $table->date('date_installation')->nullable()->comment('تاريخ التثبيت');
            $table->date('date_retirement')->comment('تاريخ التقاعد');
            $table->string('payroll_statement')->comment('بيان الراتب');
            $table->string('establishment')->comment('المنشاءة');
            $table->string('foundation_E')->comment('المؤسسة E');
            $table->string('salary_category')->nullable()->comment('فئة الراتب المستخدمة للنظام');
            $table->string('installation_new')->comment('التثبيت الجديد')->nullable();
            $table->string('contract_type')->comment('نوع العقد')->nullable();
            $table->string('number_working_days',50)->comment('عدد أيام العمل')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_data');
    }
};
