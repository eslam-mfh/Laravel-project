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
        Schema::create('advice', function (Blueprint $table) {
            $table->id();
            $table->text('advice')->nullable(); // حقل النص
            $table->string('media')->nullable(); // مسار الوسائط (صورة أو فيديو)
            $table->string('media_type')->nullable(); // نوع الوسائط (image أو video)
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
        Schema::dropIfExists('advice');
    }
};
