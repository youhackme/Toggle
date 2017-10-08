<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 08/10/2017
 * Time: 22:23
 */

namespace App\Providers;

use Pdp\Parser;
use Pdp\PublicSuffixListManager;
use Illuminate\Support\ServiceProvider;

class UriServiceProvider extends ServiceProvider
{

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
    public function register()
    {


        $this->app->singleton('Uri', function () {
            $pslManager = new PublicSuffixListManager();

            return new Parser($pslManager->getList());;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Uri'];
    }

}