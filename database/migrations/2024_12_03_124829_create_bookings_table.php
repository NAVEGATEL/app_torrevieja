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
            
            $table->string('product_name')->nullable();
            $table->string('supplier_company_name')->nullable();
            $table->string('seller_company_name')->nullable();

            $table->string('language_code')->nullable();
            $table->string('location')->nullable();
            $table->string('service_flow')->nullable();

            $table->timestamp('date_event')->nullable();
            $table->timestamp('date_prebooking')->nullable();
            $table->timestamp('date_booking')->nullable();
            $table->timestamp('date_modified')->nullable();
            $table->timestamp('date_enjoyed')->nullable();

            $table->string('client_name')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_id')->nullable(); 
            $table->string('client_status')->nullable(); 

            $table->string('currency')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('payment_partial', 10, 2)->nullable();

            $table->json('ticket_type_count')->nullable();
            $table->json('payment_transaction')->nullable();
            $table->string('status')->nullable();
            $table->string('source')->nullable();
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
