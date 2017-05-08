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

class Plugin extends WordPressAbstract
{
    // * ways to check for presence of plugins:
    //   - based on urls e.g wp-content/plugins/w3totalcache
    //   - based on class names and ids
    //   - Based on headers
    //   - html comments such as "html": "<!--[^>]+WP-Super-Cache",
    //   -

    public $siteAnatomy;

    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;
        $this->getPluginFromDictionary();
        $this->getPluginFromHtml();

        return $this;
    }

    /**
     * Fetch plugin from html source code.
     */
    public function getPluginFromHtml()
    {
        if (preg_match_all('/\/wp-content\/plugins\/(.+?)\//i', $this->siteAnatomy->html, $matches)) {
            if (! empty($matches[1])) {
                $plugins = array_unique($matches[1]);
                foreach ($plugins as $plugin) {
                    $this->setPlugin($plugin, 'Detected from html source code');
                }
            }
        }
    }

    /**
     * Identify from dictionary attack.
     *
     * @return $this
     */
    public function getPluginFromDictionary()
    {
        foreach ($this->dictionary() as $dictionary) {
            foreach ($dictionary['plugin'] as $name => $plugin) {
                foreach ($plugin['headers'] as $headerRegex) {
                    foreach ($this->siteAnatomy->headers as $siteAnatomyHeader) {
                        if (is_array($siteAnatomyHeader)) {
                            foreach ($siteAnatomyHeader as $value) {
                                if (preg_match($headerRegex, $value)) {
                                    $this->setPlugin($name, "Detected in header by regex $headerRegex");
                                }
                            }
                        } else {
                            echo "$siteAnatomyHeader is not an array";
                        }
                    }
                }
            }
        }

        return $this;
    }
}
