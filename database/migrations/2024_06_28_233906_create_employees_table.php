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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('employee_id')->unique();
            $table->date('date_of_birth');
            $table->smallInteger('age');
            $table->enum('gender',['ذكر','أنثى']);
            $table->string('matrimonial_status')->comment('الحالة الزوجية');
            $table->smallInteger('number_wives')->default(0);
            $table->smallInteger('number_children')->default(0);
            $table->smallInteger('number_university_children')->default(0)->comment('عدد الأولاد في الجامعة');
            $table->string('scientific_qualification')->comment('المؤهل العلمي');
            $table->string('specialization')->nullable()->comment('التخصص');
            $table->string('university')->nullable();
            $table->string('area');
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
