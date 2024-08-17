<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('available_slots_id')->constrained()->nullable();
            $table->string('service');
            $table->string('specialist')->nullable() ;
            $table->string('date');
            $table->string('time');
            $table->integer('status')->default("0") ;// 0:pending 1:approved 2:completed
            $table->integer('type')->default("0") ; //1 for offer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
