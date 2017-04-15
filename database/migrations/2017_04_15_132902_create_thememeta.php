<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThememeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('thememeta', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('themeid')->length(10)->unsigned();
            $table->string('slug', 200);
            $table->string('screenshotExternalUrl', 200);
            $table->string('screenshotHash', 32);
            $table->string('authorname', 50);
            $table->string('authorurl', 200);
            $table->enum('status', ['active', 'inactive']);
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
        Schema::dropIfExists('thememeta');
    }
}
