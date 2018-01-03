<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/01/2018
 * Time: 09:30
 */

namespace App\Engine\ApplicationComponents;

/**
 * You are a much more specific type of application. Isn't it?
 * Class WordPress
 * @package App\Engine\ApplicationComponents
 * Notice: All attributes except themes and plugins have been duplicated to display
 *         a much more organised json object
 */
class WordPress extends Application
{
    /**
     * The name of your application
     * @var
     */
    public $name;
    /**
     * How confident are you on a scale of 1-100 that this is app is really what it is?
     * @var
     */
    public $confidence;
    /**
     * The version of the application
     * @var
     */
    public $version;
    /**
     * The icon of your application
     * @var
     */
    public $icon;
    /**The website of your application
     * @var
     */
    public $website;
    /**
     * Which categories your application belongs to?
     * @var
     */
    public $categories;
    /**
     * How much power your app has? Is it authoritative enough?
     * @var bool
     */
    public $poweredBy = false;

    /**
     * The theme(s) attached to this app
     * @var
     */
    public $themes;

    /**
     * The plugins attached to this app
     * @var
     */
    public $plugins;


    /**
     * Set the theme name
     *
     * @param Theme $theme
     *
     * @return $this
     */
    public function setTheme(Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }


    /**
     * Set the plugin name
     *
     * @param Plugin $plugin
     *
     * @return $this
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;

        return $this;
    }

}