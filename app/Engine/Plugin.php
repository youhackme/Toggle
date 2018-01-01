<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 25/12/2017
 * Time: 17:24
 */

namespace App\Engine;


class Plugin
{

    /**
     * Plugin Name
     * @var
     */
    public $name = null;

    /**
     * Plugin Slug
     * @var
     */
    public $slug = null;

    /**
     * Plugin Description
     * @var
     */
    public $description = null;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $name
     *
     * @return Plugin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $slug
     *
     * @return Plugin
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param mixed $description
     *
     * @return Plugin
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function compute()
    {

        $methods = get_class_methods($this);

        $methods = collect($methods)->filter(function ($methodName) {
            if (strpos($methodName, 'get') !== false) {

                return $methodName;
            }
        });

        foreach ($methods as $method) {
            if (is_null($this->$method())) {

                switch ($method) {
                    case 'getDescription':
                        $pluginMeta = \App\Models\PluginMeta::where('slug', $this->getSlug())
                                                            ->get()->first();
                        if ( ! is_null($pluginMeta)) {
                            $this->setDescription($pluginMeta->plugin->description);
                            $this->setName($pluginMeta->plugin->name);
                        }
                        
                        break;

                }
            }
        }

        return $this;
    }


}