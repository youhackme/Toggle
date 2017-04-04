<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 04/04/2017
 * Time: 10:50
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Goutte\Client as GoutteClient;
use App;

class GoutteServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		$this->app->singleton( 'goutte', function () {
			return new GoutteClient;
		} );

	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {

		return [ 'goutte' ];

	}

}