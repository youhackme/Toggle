<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 23/04/2017
 * Time: 12:02.
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\SiteAnatomy;
use App\Engine\WordPress\WordPressAbstract;

class Screenshot extends WordPressAbstract
{
    /**
     * Inject an instance of \App\Engine\SiteAnatomy.
     *
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
     * Find screenshot path of the undeerlying theme.
     */
    public function findScreenshot()
    {
        $allowedScreenshotExtension = ['.png', '.jpg', '.jpeg', '.gif'];
        $regex                      = '/(?:href|src)=(?:\'|")((?:\S+)\/wp-content\/themes\/([\w-_.]+))\/(?:.+?)(?:[\'|"])/im';
        if (preg_match_all($regex, $this->siteAnatomy->html, $themeAliases)) {

            $pathToThemes = array_values(array_unique($themeAliases[1]));
            $themeAliases = array_values(array_unique($themeAliases[2]));
            foreach ($pathToThemes as $key => $pathToTheme) {
                foreach ($allowedScreenshotExtension as $extension) {

                    $screenshotUrl = $pathToTheme . '/screenshot' . $extension;
                    if ($this->urlExist($screenshotUrl) == 200) {
                        if (isset($themeAliases[$key])) {
                            $this->setScreenshot($themeAliases[$key], $screenshotUrl);
                            break;
                        }

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
    public function urlExist($screenshotUrl)
    {
        $goutteClient = \App::make('goutte');
        try {
            $goutteClient->request('GET', $screenshotUrl);

            return $goutteClient->getResponse()->getStatus();
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            echo $e->getMessage();

            return false;
        }
    }
}
