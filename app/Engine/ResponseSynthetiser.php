<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 24/12/2017
 * Time: 08:35
 */

namespace App\Engine;


class ResponseSynthetiser
{


    public $url;
    public $host;
    public $debugMode;
    public $applications;
    public $applicationsByCategory;

    public function __construct(TechnologyBuilderInterface $responseLive, TechnologyBuilderInterface $responseCached)
    {
        $this->mergeUrls($responseLive, $responseCached);
        $this->mergeHosts($responseLive, $responseCached);
        $this->mergeDebugMode();
        $this->mergeApplications($responseLive, $responseCached);
        $this->addApplicationsByCategory();
    }

    public function mergeUrls($responseLive, $responseCached)
    {
        if (isset($responseLive->url)) {
            $this->url = $responseLive->url;
        } else {
            $this->url = $responseCached->url;
        }

    }


    public function mergeHosts($responseLive)
    {
        $this->host = $responseLive->host;
    }

    public function mergeDebugMode()
    {
        $this->debugMode = false;
    }

    public function mergeApplications($responseLive, $responseCached)
    {
        $applicationsFromLiveResponse   = [];
        $applicationsFromCachedResponse = [];

        if (isset($responseLive->applications)) {
            $applicationsFromLiveResponse = $responseLive->applications;
        }
        if (isset($responseCached->applications)) {
            $applicationsFromCachedResponse = $responseCached->applications;
        }

        $this->applications = array_merge($applicationsFromLiveResponse, $applicationsFromCachedResponse);

    }

    public function addApplicationsByCategory()
    {
        $this->applicationsByCategory = $this->sortApplicationByCategory($this->applications);
    }


    public function sortApplicationByCategory($applications)
    {
        if (isset($applications['error'])) {
            return false;
        }
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


}