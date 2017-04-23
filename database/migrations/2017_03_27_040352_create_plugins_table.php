<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            /**
             * The PK
             */
            $table->increments('id');
            /**
             * The external identifier
             */
            $table->string('uniqueidentifier', 150);
            /**
             * The official name of the plugin
             */
            $table->string('name', 200);
            /**
             * The preview link without the iframe
             */
            $table->string('previewlink', 255)->nullable();

            /**
             * The 'indirect' download link
             */
            $table->string('downloadlink', 200)->nullable();

            /**
             * The description of the plugin
             */
            $table->text('description', 255)->nullable();

            /**
             * The official screenshot of the plugin
             */
            $table->string('screenshoturl', 200)->nullable();

            /**
             * The provider of the plugin
             */
            $table->string('provider', 50)->nullable();
            /**
             * The category name
             */
            $table->string('category', 255)->nullable();
            /**
             * Is this plugin free or paid?
             */
            $table->enum('type', ['free', 'premium']);
            /**
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
        Schema::dropIfExists('plugins');
    }
}
