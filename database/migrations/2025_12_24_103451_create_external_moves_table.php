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
        Schema::create('external_moves', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('type')->comment('take it to App\Models\Enums\ExternalMoveTypeEnum');
            $table->text('description')->nullable();
            $table->double('amount')->comment('outcoming amount must be negative');
            $table->foreignIdFor(App\Models\PointOfSale::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Client::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\ExternalMove::class, 'parent_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->dateTime('date')->comment('date and time in datetime picker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_moves');
    }
};
