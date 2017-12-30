<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 24/12/2017
 * Time: 22:44
 */

namespace App\Engine;


class App
{

    public $name;
    public $confidence;
    public $version;
    public $icon;
    public $website;
    public $categories;
    public $poweredBy = false;
    public $themes;
    public $plugins;


    /**
     * @param mixed $name
     *
     * @return App
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $confidence
     *
     * @return App
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;

        return $this;
    }

    /**
     * @param mixed $version
     *
     * @return App
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param mixed $icon
     *
     * @return App
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param mixed $website
     *
     * @return App
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @param mixed $categories
     *
     * @return App
     */
    public function setCategories(Array $categories)
    {

        $primaryCategories = ['CMS', 'Ecommerce', 'Message Boards'];
        foreach ($categories as $category) {
            if (in_array($category, $primaryCategories)) {
                $this->poweredBy = true;
            }
        }
        $this->categories = $categories;

        return $this;
    }

    public function setTheme(Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    public function setPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;

        return $this;
    }


}