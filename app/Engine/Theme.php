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

}