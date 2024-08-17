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
        Schema::create('book_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ;
            $table->foreignId('offer_id')->constrained()->onDelete('cascade') ;
            $table->date('date');
            $table->time('time');
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('book_offers');
    }
};
