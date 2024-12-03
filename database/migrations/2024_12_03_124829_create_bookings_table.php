<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('short_id')->unique();
            $table->string('product_name');
            $table->string('supplier_company_name');
            $table->string('seller_company_name');
            $table->string('language_code');
            $table->string('location');
            $table->string('service_flow');
            $table->timestamp('date_event')->nullable();
            $table->timestamp('date_prebooking')->nullable();
            $table->timestamp('date_booking')->nullable();
            $table->timestamp('date_modified')->nullable();
            $table->timestamp('date_enjoyed')->nullable();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email')->nullable();
            $table->string('currency');
            $table->decimal('total_price', 10, 2);
            $table->decimal('payment_partial', 10, 2);
            $table->json('ticket_type_count');
            $table->json('payment_transaction')->nullable();
            $table->string('status');
            $table->string('source');
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
