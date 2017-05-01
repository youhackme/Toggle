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

class Theme extends WordPressAbstract
{
    // * detect theme based on
    // -- screenshot hash
    // -- theme alias => wp-content/themes/theme-name
    // -- meta data in style sheets

    public $theme;
    public $siteAnatomy;

    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;

        $this->theme = $this->getThemeAlias();

        return $this;
    }

    /**
     * Attempt to extract the theme Alias.
     */
    public function getThemeAlias()
    {
        if (preg_match_all('/\/wp-content\/themes\/(.+?)\//', $this->siteAnatomy->html, $matches)) {
            if ( ! empty($matches[1])) {
                $templates = array_unique($matches[1]);
                foreach ($templates as $template) {
                    $this->setTheme($template);
                }
            }
        }
    }

    //@TOOD
    // If a theme is using a plugin such as W3 total cache, it is not possible to determine theme slug
    // based on html source code, but possible from external style sheet.
    // e.g http://shopkeeper.getbowtied1.netdna-cdn.com/wp-content/plugins/bwp-minify/cache/minify-b1-woocommerce-layout-696fe48193d4d3919c2d43401e665f18.css?ver=1493635800
}
