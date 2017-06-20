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

class Theme extends WordPressAbstract
{
    // * detect theme based on
    // -- screenshot hash
    // -- theme alias => wp-content/themes/theme-name
    // -- meta data in style sheets

    public $siteAnatomy;

    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;

        $this->extractThemeAliasFromHtml();

        $this->extractThemeAliasFromStyleSheets();

        return $this;
    }

    /**
     * Attempt to extract the theme Alias from Html.
     */
    public function extractThemeAliasFromHtml()
    {
        $themes = $this->extractThemeAlias($this->siteAnatomy->html);
        foreach ($themes as $theme) {
            $this->setTheme($theme);
        }
    }

    /**
     * Extract Theme alias from stylesheet.
     */
    public function extractThemeAliasFromStyleSheets()
    {
        $responses = $this->launchAsyncRequests();

        foreach ($responses as $key => $response) {
            $url = $this->siteAnatomy->styles[$key];

            if ($response['state'] == 'fulfilled') {
                if ($response['value']->getStatusCode() == 200) {
                    $themes = $this->extractThemeAlias($response['value']->getBody()->getContents());
                    foreach ($themes as $theme) {
                        $screenshotPath = $this->buildScreenshotPath($url, $theme);
                        $this->setTheme($theme);
                        $this->setScreenshot($theme, $screenshotPath);
                    }
                }
            }
        }
    }

    /**
     * Build screenshot path.
     *
     * @param $url   The input url that should normally contain 'wp-content'
     * @param $theme The theme name
     *
     * @return string the full path to download the screenshot.png
     */
    private function buildScreenshotPath($url, $theme)
    {
        if (preg_match('/((.*)\/)wp-content\//', $url, $matches)) {
            $screenshotUrl = $matches[0] . '/themes/' . $theme . '/screenshot.png';

            return $screenshotUrl;
        }
    }

    /**
     * Extract the theme alias bases on the content.
     *
     * @param $content it could be the HTML source, css sheet.
     *
     * @return array A list of theme found in source code, it could be the parent, child theme or framework
     */
    private function extractThemeAlias($content)
    {
        $themes = [];
        if (preg_match_all('/\/wp-content\/themes\/(.+?)\//', $content, $matches)) {
            if ( ! empty($matches[1])) {
                $templates = array_unique($matches[1]);

                foreach ($templates as $template) {
                    $themes[] = $template;
                }
            }
        }

        return $themes;
    }

    /**
     * Launch asynchronous requests.
     *
     * @param $host The host e.g toggle.me
     *
     * @return mixed
     */
    private function launchAsyncRequests()
    {
        $promises     = [];
        $goutteClient = \App::make('goutte');
        if (isset($this->siteAnatomy->styles)) {
            foreach ($this->siteAnatomy->styles as $styleSheet) {
                $promises[] = $goutteClient->getClient()->getAsync($styleSheet);
            }

            return Promise\settle($promises)->wait();
        }

        return false;

    }

    //@TOOD
    // If a theme is using a plugin such as W3 total cache, it is not possible to determine theme slug
    // based on html source code, but possible from external style sheet.
    // e.g http://shopkeeper.getbowtied1.netdna-cdn.com/wp-content/plugins/bwp-minify/cache/minify-b1-woocommerce-layout-696fe48193d4d3919c2d43401e665f18.css?ver=1493635800
}
