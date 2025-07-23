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
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('booking_trx_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('started_time');
            $table->date('schedule_at');
            $table->string('proof')->nullable();
            $table->string('post_code');
            $table->string('city');
            $table->unsignedBigInteger('sub_total');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedBigInteger('total_tax_amount');
            $table->boolean('is_paid');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_transactions');
    }
};
