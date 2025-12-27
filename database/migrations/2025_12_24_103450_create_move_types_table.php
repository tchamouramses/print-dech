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
        Schema::create('move_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('range')->default(\App\Models\Enums\MoveRangeEnum::GLOBAL->value)->comment('take it to App\Models\Enums\MoveRangeEnum');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_move_types');
    }
};
