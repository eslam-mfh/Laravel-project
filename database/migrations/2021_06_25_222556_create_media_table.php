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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name_1')->nullable();
            $table->string('file_path_1');
            $table->string('file_type_1');
            $table->string('mime_type_1');
            $table->integer('file_size_1')->nullable();
            $table->string('file_name_2');
            $table->string('file_path_2');
            $table->string('file_type_2');
            $table->string('mime_type_2');
            $table->integer('file_size_2');
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
        Schema::dropIfExists('media');
    }
};
