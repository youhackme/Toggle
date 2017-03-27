<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'themes', function ( Blueprint $table ) {
			$table->engine = 'InnoDB';
			$table->increments( 'id' );
			$table->integer( 'uniqueidentifier' );
			$table->string( 'name', 50 );
			$table->string( 'description', 255 )->nullable();
			$table->string( 'author', 100 )->nullable();
			$table->string( 'url', 40 )->nullable();
			$table->string( 'provider', 150 )->nullable();
			$table->string( 'alias', 50 )->nullable();
			$table->string( 'screenshotUrl', 150 )->nullable();
			$table->string( 'screenshotHash', 32 )->nullable();
			$table->string( 'version', 5 )->nullable();
			$table->string( 'category', 150 )->nullable();
			$table->string( 'tags', 100 )->nullable();
			$table->string( 'themePreviewUrl', 255 )->nullable();
			$table->string( 'themeDownloadUrl', 255 )->nullable();
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
		Schema::dropIfExists( 'themes' );
	}
}
