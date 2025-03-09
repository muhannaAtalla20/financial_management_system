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
        Schema::create('specific_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('month');
            $table->decimal('salary', 10, 2)->default(0);
            $table->smallInteger('number_of_days')->nullable()->default(0);;
            $table->decimal('today_price', 10, 2)->nullable()->default(0);;
            $table->timestamps();
            $table->unique(['employee_id','month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specific_salaries');
    }
};
