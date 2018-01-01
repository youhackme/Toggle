<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 25/12/2017
 * Time: 17:24
 */

namespace App\Engine;


class Theme
{

    public $name;
    public $slug;
    public $description;
    public $screenshotHash;
    public $screenshotUrl;

    /**
     * @param mixed $name
     *
     * @return Theme
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $slug
     *
     * @return Theme
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $description
     *
     * @return Theme
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $screenshotHash
     *
     * @return $this
     */
    public function setScreenshotHash($screenshotHash)
    {
        $this->screenshotHash = $screenshotHash;

        return $this;

    }

    /**
     * @param $screenshotUrl
     *
     * @return $this
     */
    public function setScreenshotUrl($screenshotUrl)
    {
        $this->screenshotUrl = $screenshotUrl;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getScreenshotHash()
    {
        return $this->screenshotHash;
    }

    /**
     * @return mixed
     */
    public function getScreenshotUrl()
    {
        return $this->screenshotUrl;
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

                        if ( ! is_null($this->getScreenshotHash())) {
                            $themeMeta = \App\Models\ThemeMeta::where('slug', $this->getSlug())
                                                              ->where('screenshotHash', $this->getScreenshotHash())
                                                              ->get()->first();
                            if ( ! is_null($themeMeta)) {
                                $this->setDescription($themeMeta->theme->description);
                            } else {
                                $this->setDescription('Theme description not found.');
                            }
                        }


                        break;

                }
            }
        }

        return $this;
    }


}