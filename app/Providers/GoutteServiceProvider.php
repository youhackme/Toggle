<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 04/04/2017
 * Time: 10:50.
 */

namespace App\Providers;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;

class GoutteServiceProvider extends ServiceProvider
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
        $this->app->singleton('goutte', function () {
            $guzzleClient = new GuzzleClient([
                'timeout'         => 60,
                'allow_redirects' => true,
                'verify'          => 'false',
                'headers'         => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',

                ],
            ]);

            $goutteClient = new GoutteClient();
            $goutteClient->setClient($guzzleClient);

            return  $goutteClient;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['goutte'];
    }
}
