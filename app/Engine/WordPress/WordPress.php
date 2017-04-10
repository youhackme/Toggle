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
     * The order each algorithm should be checked
     * @var array
     */
    protected $algorithms = [
        \App\Engine\WordPress\Algorithm\Html::class,
        \App\Engine\WordPress\Algorithm\Theme::class,
        \App\Engine\WordPress\Algorithm\Plugin::class,
//		\App\Engine\WordPress\Algorithm\Link::class,
//		\App\Engine\WordPress\Algorithm\Robot::class,
//		\App\Engine\WordPress\Algorithm\Uri::class,

    ];


    /**
     * WordPress constructor.
     *
     * @param SiteAnatomy $siteAnatomy
     */
    public function __construct(SiteAnatomy $siteAnatomy)
    {

        $this->siteAnatomy = $siteAnatomy;

    }

    /**
     * Detect CMS based on each algorithm
     * @return array
     */
    public function detect()
    {

        $result = [];
        foreach ($this->algorithms as $algorithm) {

            $result[] = (new $algorithm)->check($this->siteAnatomy);

        }

        return $result;

    }


}