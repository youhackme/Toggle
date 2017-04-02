<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'plugins', function ( Blueprint $table ) {
			$table->engine = 'InnoDB';
			$table->increments( 'id' );
			$table->integer( 'uniqueidentifier' );
			$table->string( 'name', 200 );
			$table->string( 'url', 200 )->nullable();
			$table->string( 'downloadlink', 200 )->nullable();
			$table->string( 'demolink', 200 )->nullable();
			$table->text( 'description', 255 )->nullable();
			$table->string( 'screenshotUrl', 150 )->nullable();
			$table->string( 'provider', 50 )->nullable();
			$table->string( 'category', 150 )->nullable();
			$table->enum( 'type', [ 'free', 'premium' ] );
			$table->timestamps();

		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'plugins' );
	}
}
