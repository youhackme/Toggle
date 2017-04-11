<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:31
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\WordPress\WordPressAbstract;

use App\Engine\SiteAnatomy;

class Robot extends WordPressAbstract
{

    /**
     * Inject an instance of \App\Engine\SiteAnatomy
     * @var
     */
    public $siteAnatomy;


    /**
     * The path to Robots.txt
     * @var
     */
    public $pathToRobotsTxt;

    /**
     * @param SiteAnatomy $siteAnatomy
     *
     * @return $this
     */
    public function check(SiteAnatomy $siteAnatomy)
    {

        $this->siteAnatomy     = $siteAnatomy;
        $host                  = parse_url($this->siteAnatomy->crawler->getBaseHref(), PHP_URL_HOST);
        $this->pathToRobotsTxt = "http://$host/robots.txt";
        $content               = $this->getRobotsTxtContent();
        $this->checkWordPressFootprints($content);

        return $this;
    }


    /**
     * Fetch the content of the Robots.txt
     */
    public function getRobotsTxtContent()
    {
        $goutteClient = \App::make('goutte');

        $goutteClient->request(
            'GET',
            $this->pathToRobotsTxt
        );

        return $content = $goutteClient->getResponse()->getContent();

    }

    /**
     * Check for WordPress footprints in robots.txt
     *
     * @param $content
     */
    public function checkWordPressFootprints($content)
    {
        if (preg_match('/(wp-admin|admin-ajax.php|wp-content)/i', $content, $matches)) {
            $this->assertWordPress('robot');
        }
    }


}