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
        Schema::create('internal_moves', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->unsigned();
            $table->string('status')->default(\App\Models\Enums\InternalMoveStatusEnum::SEND->value);
            $table->foreignIdFor(App\Models\PointOfSale::class, 'point_sender_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\PointOfSale::class, 'point_receiver_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\MoveType::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class, 'sender_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class, 'receiver_id')->constrained()->cascadeOnDelete();
            $table->dateTime('send_date');
            $table->dateTime('received_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_moves');
    }
};
