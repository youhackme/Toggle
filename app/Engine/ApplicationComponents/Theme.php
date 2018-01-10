<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 25/12/2017
 * Time: 17:24
 */

namespace App\Engine\ApplicationComponents;


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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getScreenshotUrl()
    {
        return $this->screenshotUrl;
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

                            $this->setDescription('Theme description not found.');

                            if ( ! is_null($themeMeta)) {
                                $this->setDescription($themeMeta->theme->description);
                            }
                        }


                        break;

                }
            }
        }

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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
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


}