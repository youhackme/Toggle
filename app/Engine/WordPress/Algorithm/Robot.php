<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:31.
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\SiteAnatomy;
use App\Engine\WordPress\WordPressAbstract;

class Robot extends WordPressAbstract
{
    /**
     * Inject an instance of \App\Engine\SiteAnatomy.
     *
     * @var
     */
    public $siteAnatomy;

    /**
     * The path to Robots.txt.
     *
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
        $host                  = $siteAnatomy->host;
        $this->pathToRobotsTxt = "http://$host/robots.txt";
        $this->checkWordPressFootprints($this->getRobotsTxtContent());

        return $this;
    }

    /**
     * Fetch the content of the Robots.txt.
     * @return bool
     */
    public function getRobotsTxtContent()
    {
        try {
            $goutteClient = \App::make('goutte');
            $goutteClient->request('GET', $this->pathToRobotsTxt);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            \Bugsnag::notifyException($e);

            return false;
        }

        return $goutteClient->getResponse()->getContent();
    }

    /**
     * Check for WordPress footprints in robots.txt.
     *
     * @param $content
     */
    public function checkWordPressFootprints($content)
    {
        if (preg_match('/(wp-admin|admin-ajax.php|wp-content)/i', $content)) {
            $this->assertWordPress('robot');
        }
    }
}
