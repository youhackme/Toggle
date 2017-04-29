<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 21:02.
 */

namespace App\Engine\WordPress;

use App\Engine\SiteAnatomy;

/**
 * The contract for the detection algorithm (Chain of Responsability design patterns)
 * Class WordPressDetector.
 */
abstract class WordPressAbstract
{
    /**
     * Plugin names found on the page.
     *
     * @var
     */
    private $plugins;

    /**
     * Store all theme names detected, ideally this should be one but we never know..
     *
     * @var
     */
    private $themes;

    /**
     * Store how many times algorithm asserts that a site is using WordPress.
     *
     * @var
     */
    private $assertWordPress = false;

    /**
     * Store WordPress version.
     *
     * @var
     */
    private $version;

    /**
     * Store the path to the theme screenshot in case WordPress has been detected.
     *
     * @var
     */
    private $screenshot;

    /**
     * Check if it statisfies the algo condition.
     *
     * @param SiteAnatomy $siteAnatomy
     *
     * @return mixed
     */
    abstract public function check(SiteAnatomy $siteAnatomy);

    /**
     * Our Sample dictionary.
     *
     * @return array
     */
    public function dictionary()
    {
        return [
            'type' => [
                'plugin' => [
                    'W3 Total Cache' => [
                        'headers' => [
                            'X-Powered-By' => '/W3 Total Cache/u',
                        ],
                        'html'    => [
                            '<!--[^>]+W3 Total Cache',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Set plugin name.
     *
     * @param      $name
     * @param null $description
     */
    public function setPlugin($name, $description = null)
    {
        if (!is_null($name) || !empty($name)) {
            $this->plugins[$name] = [
                'description' => $description,
            ];

            $this->assertWordPress($name, 'Implies WordPress, if you have a plugin name, right?');
        }
    }

    /**
     * Get list of plugin.
     *
     * @return mixed
     */
    public function getPlugin()
    {
        return $this->plugins;
    }

    /**
     * Set theme name.
     *
     * @param      $name
     * @param null $description
     */
    public function setTheme($name, $description = null)
    {
        if (!is_null($name) || !empty($name)) {
            $this->themes[$name] = [
                'description' => $description,
            ];

            $this->assertWordPress($name, 'Implies WordPress, if you have a theme name, right?');
        }
    }

    /**
     * Get Score.
     *
     * @return mixed
     */
    public function getTheme()
    {
        return $this->themes;
    }

    /**
     * Assert this site is using WordPress.
     *
     * @param      $tag
     * @param null $description
     */
    public function assertWordPress($tag, $description = null)
    {
        if (!is_null($tag) || !empty($tag)) {
            $this->assertWordPress[$tag] = [
                'description' => $description,
            ];
        }
    }

    /**
     * Get WordPress Assertions.
     *
     * @return bool
     */
    public function getWordPressAssertions()
    {
        return $this->assertWordPress;
    }

    /**
     * Get WordPress version.
     *
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set WordPress version.
     *
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version[] = $version;
    }

    /**
     * Get theme screenshot.
     *
     * @return mixed
     */
    public function getScreenshot()
    {
        return $this->screenshot;
    }

    /**
     * Set WordPress screenshot.
     *
     * @param $themealias
     * @param $screenshot
     */
    public function setScreenshot($themealias, $screenshot)
    {
        $this->screenshot[$themealias] = $screenshot;
    }
}
