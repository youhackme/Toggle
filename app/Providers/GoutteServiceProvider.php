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
            $userAgent    = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
            $useragent    = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
            $guzzleClient = new GuzzleClient([
                'timeout'         => 30,
                'allow_redirects' => true,
                'verify'          => false,
                'headers'         => [
                    'User-Agent'                => $userAgent,
                    'Referer'                   => 'https://google.com',
                    'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Pragma'                    => 'no-cache',
                    'Accept-Encoding'           => 'gzip, deflate, sdch, br',
                    'Accept-Language'           => 'en-US,en;q=0.8',
                    'Upgrade-Insecure-Requests' => '1',
                    'Cache-Control'             => 'no-cache',
                    'Cookie'                    => 'cmses=f9afepap9en5inkhoi7gma6j64s5o60jv7dmk8t7b8lpq04pbeghka7ecsj66pd3ub45e6c1o32incuefp96j4sgmcprldvi8pva8m1; cmfts=f9afepap9en5inkhoi7gma6j64s5o60jv7dmk8t7b8lpq04pbeghka7ecsj66pd3ub45e6c1o32incuefp96j4sgmcprldvi8pva8m1; cmphn=0; ajs_anonymous_id=%22aba42c37-8fb1-4168-85e4-6d75e8c3971b%22; D_SID=41.136.227.246:GLT9jtfiNRgt3w8LjEiIm+Iexspw+4Eg7usVNn5Ick4; __ssid=91e1cf1a-d102-4b39-b628-31a9f2d3cbb6; wm=1; optimizelyEndUserId=oeu1495771059893r0.9084003615704002; optimizelySegments=%7B%22185891773%22%3A%22false%22%2C%22185891774%22%3A%22gc%22%2C%22186254596%22%3A%22direct%22%2C%222714810811%22%3A%22none%22%2C%225512560388%22%3A%22true%22%2C%225528031144%22%3A%22true%22%7D; optimizelyBuckets=%7B%7D; __stripe_mid=c549ae95-1be4-47ba-83f9-83b5147cf779; __stripe_sid=ee366fb2-98a8-4985-9d08-d7c3d3fbd0fc; cmsfp=1; ajs_user_id=null; ajs_group_id=null; _ga=GA1.2.104856898.1495740119; _gid=GA1.2.883736094.1495776438; mp_de24c0c70590f9202ded0ad605abca4b_mixpanel=%7B%22distinct_id%22%3A%20%2215c410efd98542-093a177d051d2f-30627509-fa000-15c410efd992f3%22%2C%22mp_lib%22%3A%20%22Segment%3A%20web%22%2C%22%24search_engine%22%3A%20%22google%22%2C%22%24initial_referrer%22%3A%20%22https%3A%2F%2Fwww.google.mu%2F%22%2C%22%24initial_referring_domain%22%3A%20%22www.google.mu%22%2C%22URL%22%3A%20%22%2Fthemes%2Fwordpress%2Fblog%2F5%22%2C%22Page%20Name%22%3A%20%22WordPress%20Blog%20Themes%20~%20Page%205%20~%20Creative%20Market%22%2C%22Page%20Type%22%3A%20%22Category%22%2C%22Signed%20In%22%3A%20false%2C%22Is%20First%20Time%20Visitor%22%3A%20true%2C%22__mps%22%3A%20%7B%22%24os%22%3A%20%22Mac%20OS%20X%22%2C%22%24browser%22%3A%20%22Chrome%22%2C%22%24browser_version%22%3A%2058%2C%22%24initial_referrer%22%3A%20%22https%3A%2F%2Fwww.google.mu%2F%22%2C%22%24initial_referring_domain%22%3A%20%22www.google.mu%22%2C%22Is%20First%20Time%20Visitor%22%3A%20true%7D%2C%22__mpso%22%3A%20%7B%7D%2C%22__mpa%22%3A%20%7B%7D%2C%22__mpu%22%3A%20%7B%7D%2C%22__mpap%22%3A%20%5B%5D%7D; mp_mixpanel__c=0; _uetsid=_ueted0a3e85; D_IID=8600341D-B765-31CC-9059-1C7B5F18493E; D_UID=8D87E393-3903-3D6F-AB36-B6013C8D36C8; D_ZID=C98F46C8-0C16-3470-ABD3-6C96498EF4FC; D_ZUID=02D71EB3-F44E-36AC-B3E3-D1144FA709AB; D_HID=9AD3D369-4FCD-34AF-9F34-81D6A4966E6E',
                    'Connection'                => 'keep-alive',
                    'Alexatoolbar-Alx_ns_ph'    => 'AlexaToolbar/alx-4.0.1',

                ],
                'cookies'         => true,

            ]);


            $goutteClient = new GoutteClient(['HTTP_USER_AGENT' => $userAgent]);
            $goutteClient->setClient($guzzleClient);

            return $goutteClient;
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
