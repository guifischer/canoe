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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('company_fund', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('company_id')
                ->references('id')->on('companies');
            $table->foreignId('fund_id')
                ->references('id')->on('funds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_fund');
        Schema::dropIfExists('companies');
    }
};
