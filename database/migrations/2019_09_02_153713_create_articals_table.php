<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('main_title');
            $table->string('secondary_title');
            $table->string('content');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('author_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articals');
    }
}
