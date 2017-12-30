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

    public $name;
    public $slug;
    public $description;

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

}