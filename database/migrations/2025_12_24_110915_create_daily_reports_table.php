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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->unsigned();
            $table->double('commission_amount')->unsigned()->default(0);
            $table->double('tip_amount')->unsigned()->default(0);
            $table->double('recap_amount')->comment('see formula in the cell of the Excel file');
            $table->double('gap_amount')->comment('see formula in the cell of the Excel file');
            $table->boolean('is_initial')->default(false);
            $table->foreignIdFor(App\Models\PointOfSale::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\MoveType::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->dateTime('day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
