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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('payment_status'); // 0 => unpaid | 1 => paid
            $table->integer('guests_count');
            $table->boolean('status')->default(0);// 0 => booking | 1 => end booking
            $table->float('final_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
