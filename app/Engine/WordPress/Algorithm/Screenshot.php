<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 23/04/2017
 * Time: 12:02
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\WordPress\WordPressAbstract;
use App\Engine\SiteAnatomy;
use GuzzleHttp\Promise;


class Screenshot extends WordPressAbstract
{

    /**
     * Inject an instance of \App\Engine\SiteAnatomy
     * @var
     */
    public $siteAnatomy;

    /**
     * Screenshot constructor.
     *
     * @param $siteAnatomy
     *
     * @return $this
     */
    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;
        $this->findScreenshot();

        return $this;
    }


    /**
     * Find screenshot path of the undeerlying theme
     */
    public function findScreenshot()
    {

        $host                       = $this->siteAnatomy->crawler->getBaseHref();
        $allowedScreenshotExtension = ['.png', '.jpg', 'jpeg', '.gif'];
        if (preg_match_all('/wp-content\/themes\/([\w]+)\//im', $this->siteAnatomy->html, $themeAliases)) {
            $themeAliases = array_unique($themeAliases[1]);
            foreach ($themeAliases as $themeAlias) {
                foreach ($allowedScreenshotExtension as $extension) {
                    $screenshotUrl = $host . '/wp-content/themes/' . $themeAlias . '/screenshot' . $extension;
                    if ($this->UrlExist($screenshotUrl) == 200) {
                        $this->setScreenshot($themeAlias, $screenshotUrl);
                        break;
                    }
                }


            }
        }

    }

    /**
     * Does this screenshot url really exist?
     *
     * @param $screenshotUrl
     *
     * @return mixed
     */
    public function UrlExist($screenshotUrl)
    {

        $goutteClient = \App::make('goutte');
        $goutteClient->request(
            'GET',
            $screenshotUrl
        );

        return $goutteClient->getResponse()->getStatus();
    }


}