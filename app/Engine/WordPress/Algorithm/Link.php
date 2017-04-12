<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:32
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\WordPress\WordPressAbstract;

use App\Engine\SiteAnatomy;


class Link extends WordPressAbstract
{

    /**
     * Inject an instance of \App\Engine\SiteAnatomy
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
        $host              = parse_url($this->siteAnatomy->crawler->getBaseHref(), PHP_URL_HOST);


        foreach ($this->commonWordPressPaths() as $commonWordPressPaths) {
            $url      = "http://$host/{$commonWordPressPaths['path']}";
            $response = $this->getPageContent($url);

            if ($response->getStatus() == 200) {
                if (preg_match_all($commonWordPressPaths['searchFor'], $response->getContent())) {
                    $this->assertWordPress('commonWordPressPaths-' . $commonWordPressPaths['searchFor']);
                }
            }
        }


        return $this;
    }

    /**
     * A dictionary containing all WordPress common path with their content
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
                'searchFor' => '/WordPress|manifest/i',
            ],
            [
                'path'      => 'wp-links-opml.php',
                'searchFor' => '/WordPress|opml/i',
            ],
            [
                'path'      => 'wp-json',
                'searchFor' => '/WordPress|wp-api/i',
            ],


        ];
    }

    /**
     * Fetch a page content
     *
     * @param $url
     *
     * @return mixed
     */
    private function getPageContent($url)
    {
        $goutteClient = \App::make('goutte');

        $goutteClient->request(
            'GET',
            $url
        );

        return $goutteClient->getResponse();

    }


}