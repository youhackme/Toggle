<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            /*
             * The PK
             */
            $table->increments('id');
            /*
             * The external identifier of the theme
             */
            $table->string('uniqueidentifier', 150);
            /*
             * The official name of the theme
             */
            $table->string('name', 100);
            /*
             * The theme description
             */
            $table->text('description', 255)->nullable();
            /*
             * Who built the theme?
             */
            $table->string('author', 100)->nullable();
            /*
             * The theme provider
             */
            $table->string('provider', 150)->nullable();
            /*
             * The theme official screenshot (not the one within the themes/ folder)
             */
            $table->string('screenshoturl', 255)->nullable();
            /*
             * In which category does this theme fit? Ecommerce? Blogs?
             */
            $table->string('category', 150)->nullable();
            /*
             * Tag this theme for future search
             */
            $table->string('tags', 100)->nullable();
            /*
             * The preview link without the iframe
             */
            $table->string('previewlink', 255)->nullable();
            /*
             * The 'indirect' download link
             */
            $table->string('downloadlink', 255)->nullable();
            /*
             * Is this theme free or paid?
             */
            $table->enum('type', ['free', 'premium']);
            /*
             * Status :
             *
             * unprocessed => theme alias not found yet
             * detected => theme alias has already been found
             * notdetected=> theme alias has not been detected
             *
             */
            $table->enum('status', ['unprocessed', 'detected', 'notdetected']);
            /*
             * The created_at and updated_at columns
             */
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
        Schema::dropIfExists('themes');
    }
}
