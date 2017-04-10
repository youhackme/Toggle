<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 21:02
 */

namespace App\Engine\WordPress;

use App\Engine\SiteAnatomy;

/**
 * The contract for the detection algorithm (Chain of Responsability design patterns)
 * Class WordPressDetector
 * @package App\Engine\WordPress
 */
abstract class WordPressAbstract
{


    /**
     * Plugin names found on the page
     * @var
     */
    public $plugins;

    /**
     * Store all theme names detected, ideally this should be one but we never know..
     * @var
     */
    public $themes;

    /**
     * Store how many times algorithm asserts that a site is using WordPress
     * @var
     */
    public $assertWordPress = false;


    /**
     * Check if it statisfies the algo condition
     *
     * @param SiteAnatomy $siteAnatomy
     *
     * @return mixed
     */
    public abstract function check(SiteAnatomy $siteAnatomy);


    /**
     * Our Sample dictionary
     * @return array
     */
    public function dictionary()
    {

        return [
            "type" => [
                "plugin" => [
                    "W3 Total Cache" => [
                        "headers" => [
                            "X-Powered-By" => "/W3 Total Cache/u",
                        ],
                        "html"    => [
                            "<!--[^>]+W3 Total Cache",
                        ],
                    ],
                ],
            ],
        ];

    }

    /**
     * Set plugin name
     *
     * @param      $name
     * @param null $description
     */
    public function setPlugin($name, $description = null)
    {
        $this->plugins[] = [
            'name'        => $name,
            'description' => $description,
        ];
    }

    /**
     * Get list of plugin
     * @return mixed
     */
    public function getPlugin()
    {
        return $this->plugins;
    }


    /**
     * Set theme name
     *
     * @param      $name
     * @param null $description
     */
    public function setTheme($name, $description = null)
    {
        $this->themes[] = [
            'name'        => $name,
            'description' => $description,
        ];
    }

    /**
     * Get Score
     * @return mixed
     */
    public function getTheme()
    {
        return $this->plugins;
    }

    /**
     * Assert this site is using WordPress
     *
     * @param      $tag
     * @param null $description
     */
    public function assertWordPress($tag, $description = null)
    {
        $this->assertWordPress[] = [
            'tag'         => $tag,
            'description' => $description,
        ];

    }

}