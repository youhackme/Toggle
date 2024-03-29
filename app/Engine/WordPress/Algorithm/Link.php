<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:32.
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\SiteAnatomy;
use App\Engine\WordPress\WordPressAbstract;
use GuzzleHttp\Promise;

class Link extends WordPressAbstract
{
    /**
     * Inject an instance of \App\Engine\SiteAnatomy.
     *
     * @var
     */
    public $siteAnatomy;

    /**
     * @param SiteAnatomy $siteAnatomy
     *
     * @return $this
     */
    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;

        $commonWordPressPaths = $this->commonWordPressPaths();
        $responses            = $this->launchAsyncRequests($this->siteAnatomy->host);

        foreach ($responses as $key => $response) {
            if ($response['state'] == 'fulfilled') {
                if ($response['value']->getStatusCode() == 200) {
                    if (isset($commonWordPressPaths[$key]['searchFor'])) {
                        if (preg_match_all($commonWordPressPaths[$key]['searchFor'], $response['value']->getBody())) {
                            $this->assertWordPress('commonWordPressPaths-' . $commonWordPressPaths[$key]['searchFor']);
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * A dictionary containing all WordPress common path with their corresponding content.
     *
     * @return array
     */
    private function commonWordPressPaths()
    {
        return [
            [
                'path'      => 'readme.html',
                'searchFor' => '/WordPress/i',
            ],
            [
                'path'      => 'wp-includes/wlwmanifest.xml',
                'searchFor' => '/WordPress|wlw\/manifest\/weblog/i',
                //We probably need to check corresponding http response type..
            ],
            [
                'path'      => 'wp-links-opml.php',
                'searchFor' => '/generator="WordPress|<\/opml>/i',
            ],
            [
                'path'      => 'wp-json',
                'searchFor' => '/WordPress|wp-api/i',
            ],
            [
                'path' => 'wp-admin/images/wordpress-logo.svg',
            ],
            [
                'path'      => 'api/oembed/1.0/embed',
                'searchFor' => '/rest_missing_callback_param/i',
            ],

        ];
    }

    /**
     * Launch asynchronous requests.
     *
     * @param $host The host e.g toggle.me
     *
     * @return mixed
     */
    private function launchAsyncRequests($host)
    {
        $promises     = [];
        $goutteClient = \App::make('goutte');

        $commonWordPressPaths = $this->commonWordPressPaths();
        foreach ($commonWordPressPaths as $commonWordPressPath) {
            $url        = "http://$host/{$commonWordPressPath['path']}";
            $promises[] = $goutteClient->getClient()->getAsync($url);
        }

        return Promise\settle($promises)->wait();
    }
}
