<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('booking_code')->unique();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('guests');
            $table->integer('nights');
            $table->string('room_type');
            $table->text('special_requests')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->integer('discount')->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2);
            $table->decimal('service_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->string('booking_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
