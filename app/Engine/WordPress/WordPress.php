<?php

namespace App\Engine\WordPress;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 22:16
 */
use App\Engine\SiteAnatomy;

/**
 * Handle the algorithm to detect if a site is using WordPress
 * @package App\Engine\WordPress
 */
class WordPress
{


    /**
     * An instance of Site Anatomy
     * @var
     */
    public $siteAnatomy;

    /**
     * Are you WordPress?!
     * @var
     */
    private $isWordPress;

    /**
     * Attempt to detect WordPress version
     * @var
     */
    private $version;

    /**
     * Attempt to detect Theme screenshot
     * @var
     */
    private $screenshot;

    /**
     * Attempt to make a unique list of plugins out of those algos
     * @var
     */
    private $plugins;

    /**
     * Attempt to determine the correct theme name out of those algos
     * @var
     */
    private $theme;

    /**
     * The order each algorithm should be checked
     * @var array
     */
    protected $algorithms = [
        \App\Engine\WordPress\Algorithm\Html::class,
        \App\Engine\WordPress\Algorithm\Theme::class,
        \App\Engine\WordPress\Algorithm\Plugin::class,
        \App\Engine\WordPress\Algorithm\Robot::class,
        \App\Engine\WordPress\Algorithm\Link::class,

    ];


    /**
     * WordPress constructor.
     *
     * @param SiteAnatomy $siteAnatomy
     */
    public function __construct(SiteAnatomy $siteAnatomy)
    {

        $this->siteAnatomy = $siteAnatomy;
        $this->detect();

    }

    /**
     * Detect CMS based on each algorithm
     * @return array
     */
    public function detect()
    {

        foreach ($this->algorithms as $algorithm) {
            $wordPress           = (new $algorithm)->check($this->siteAnatomy);
            $this->isWordPress[] = $wordPress->getWordPressAssertions();
            $this->theme[]       = $wordPress->getTheme();
            $this->plugins[]     = $wordPress->getPlugin();
            $this->screenshot[]  = $wordPress->getScreenshot();
            $this->version[]     = $wordPress->getVersion();
        }

    }

    /**
     * Are you WordPress? You have the last word!
     * @return bool
     */
    public function isWordPress()
    {

        if ( ! empty(array_collapse($this->isWordPress))) {
            return true;
        }

        return false;
        // Cycle through each algorithm and find out through assertWordPress
    }

    /**
     * Get the list of plugins being used, again, you have the last Word
     * @return array
     */
    private function plugins()
    {
        return array_collapse($this->plugins);
        // Cycle through each algorithm and find out through getPlugin
        // Find more information from plugin database now
    }

    /**
     * Get the theme name, you have the last word, duh.
     * @return array|bool|int|string
     */
    private function theme()
    {
        $themeAlias = array_collapse($this->theme);
        if ( ! empty($themeAlias)) {

            if (count($themeAlias) > 1) {

                Bugsnag::notifyError('Anomaly', "More than one theme detected");

                foreach ($themeAlias as $alias => $rubbish) {
                    return $alias;
                }
            }

            return $themeAlias;
        }

        return false;
        // Cycle through each algorithm and find out through getTheme
        // Find more information from theme database now
    }

    /**
     * Tell us the real WordPress version
     * @return bool
     */
    private function version()
    {
        //@Todo: If more than one different version is found, then something is wrong. Send to bugsnag.
        return false;
    }

    /**
     * Give us the theme's screeeshot path
     * @return bool
     */
    private function screenshot()
    {
        //@Todo: More than one url found? Not normal. Send to bugsnag for further analysis.
        return false;
    }

    /**
     * Reveal the WordPress Bold N Nuts
     * @return string
     */
    public function details()
    {
        return json_encode([
            'wordpress'  => true,
            'version'    => $this->version(),
            'theme'      => $this->theme(),
            'plugins'    => $this->plugins(),
            'screenshot' => $this->screenshot(),
        ]);
    }


}