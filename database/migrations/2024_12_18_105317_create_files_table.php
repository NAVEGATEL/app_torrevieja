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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->string('client_name')->nullable();
            $table->string('dni')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->datetime('date_booking')->nullable();
            $table->string('anyoNacimiento')->nullable();
            $table->string('short_id')->nullable();
            $table->string('client_kind')->nullable()->default('blue');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('files');
    }
    
};
