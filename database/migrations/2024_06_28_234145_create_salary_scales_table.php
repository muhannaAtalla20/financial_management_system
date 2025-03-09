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
        Schema::create('salary_scales', function (Blueprint $table) {
            $table->id();
            $table->decimal('10',10,2)->default(0);
            $table->decimal('9',10,2)->default(0);
            $table->decimal('8',10,2)->default(0);
            $table->decimal('7',10,2)->default(0);
            $table->decimal('6',10,2)->default(0);
            $table->decimal('5',10,2)->default(0);
            $table->decimal('4',10,2)->default(0);
            $table->decimal('3',10,2)->default(0);
            $table->decimal('2',10,2)->default(0);
            $table->decimal('1',10,2)->default(0);
            $table->decimal('C',10,2)->default(0);
            $table->decimal('B',10,2)->default(0);
            $table->decimal('A',10,2)->default(0);
            $table->string('percentage')->comment('النسبة');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_scales');
    }
};
