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
 */
class WordPress extends Application
{
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