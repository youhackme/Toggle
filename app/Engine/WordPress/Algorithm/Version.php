<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 12/04/2017
 * Time: 19:56.
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\SiteAnatomy;
use App\Engine\WordPress\WordPressAbstract;

class Version extends WordPressAbstract
{
    //Algorithm for finding WordPress version
    // 1. https://darktips.com/wp-links-opml.php - Done
    // 2. wp-includes/wlwmanifest.xml
    // 3. In meta tag - Done
    // 4. from source code in login page E.g load-styles.php?c=1&amp;dir=ltr&amp;load%5B%5D=dashicons,buttons,forms,l10n,login&amp;ver=4.7.3

    public $siteAnatomy;

    /**
     * @param SiteAnatomy $siteAnatomy
     *
     * @return $this
     */
    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;

        $this->getVersionFromHtml();
        $this->getVersionFromOPML();

        return $this;
    }


    /**
     * Get version from the current html source code
     */
    public function getVersionFromHtml()
    {
        if (preg_match('/WordPress\s+([\d.]+)/', $this->siteAnatomy->html, $matches)) {
            if ( ! empty($matches[1])) {
                $version = $matches[1];
                $this->setVersion($version);
            }
        }
    }

    /**
     * Get version from wordpress OPML page
     */
    public function getVersionFromOPML()
    {
        $content = $this->getContentFor('http://' . $this->siteAnatomy->host . '/wp-links-opml.php');
        if ($content !== false) {

            if (preg_match('/<!--\s+generator="WordPress\/([\d.]+)"\s+-->/im', $content, $matches)) {

                if ( ! empty($matches[1])) {
                    $version = $matches[1];
                    $this->setVersion($version);
                }
            }
        }
    }


    /**
     *  Fetch the content for a specific url
     *
     * @param $url
     *
     * @return mixed
     */
    public function getContentFor($url)
    {
        try {
            $goutteClient = \App::make('goutte');
            $goutteClient->request('GET', $url);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            \Bugsnag::notifyException($e);
        }

        return $goutteClient->getResponse()->getContent();
    }

}
