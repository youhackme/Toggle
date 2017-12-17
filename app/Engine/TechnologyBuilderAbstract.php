<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/12/2017
 * Time: 21:29
 */

namespace App\Engine;

use Request;

class TechnologyBuilderAbstract
{
    /**
     * The url of the website
     * @var
     */
    public $url;

    /**
     * The host of the website
     * @var
     */
    public $host;

    /**
     * Are we on debugmore?
     * @var
     */
    public $debugMode;

    /**
     * An array of applications detected
     * @var
     */
    public $applications;

    /**
     * Holds the applications sorted by their category
     * @var
     */
    public $applicationsByCategory;


    /**
     * Set the url
     */
    public function addUrl()
    {
        $this->url = Request::input('url');

        if (Request::method() == 'POST') {
            $this->url = urldecode(Request::input('url'));
        }

    }

    /**
     * Set the host
     */
    public function addHost()
    {
        $uri = \App::make('Uri');


        $this->host = $uri->parseUrl(
            $this->url
        )->host->host;

    }


    /**
     * Set debug mode
     */
    public function addDebugMode()
    {
        $this->debugMode = false;
    }

    /**
     * Sort apps by their category(ies)
     */
    public function addApplicationsByCategory()
    {
        $this->applicationsByCategory = $this->sortApplicationByCategory($this->applications);
    }

    /**
     *
     * Group technologies by category
     *
     * @param $applications
     *
     * @return array
     */
    public function sortApplicationByCategory($applications)
    {
        $json                  = json_decode(file_get_contents(app_path() . '/../node_modules/togglyzer/apps.json'));
        $categories            = $json->categories;
        $applicationByCategory = [];

        foreach ($categories as $category) {

            $categoryName = $category->name;
            if ( ! empty($applications)) {

                foreach ($applications as $appName => $app) {
                    $appCategories = $app->categories;

                    if (in_array($categoryName, $appCategories)) {
                        $applicationByCategory[$categoryName][] = $app;
                    }

                }

            }
        }

        return $applicationByCategory;
    }


    public function formatJson()
    {

        return $this;
    }
}