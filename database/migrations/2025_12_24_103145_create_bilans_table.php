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
        Schema::create('bilans', function (Blueprint $table) {
            $table->id();
            $table->double('total_external_move_amount')->default(0);
            $table->double('total_internal_move_amount')->default(0);
            $table->double('daily_report_amount')->default(0);
            $table->double('daily_commission_amount')->default(0);
            $table->double('daily_gap_amount')->default(0);
            $table->double('daily_tip_amount')->default(0);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilans');
    }
};
