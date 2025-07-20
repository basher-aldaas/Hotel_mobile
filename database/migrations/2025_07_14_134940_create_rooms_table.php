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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->text('description');
            $table->double('price');
            $table->boolean('wifi')->default(0);//0 => no  | 1 => yes
            $table->enum('room_type' , ['regular' , 'premium' , 'deluxe'])->default('regular');
            $table->boolean('status')->nullable()->default(null);// عمود زيادة
            $table->integer('bed_number');
            $table->float('valuation')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
