<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:01
 */

namespace App\Engine;

use App\Http\Requests\ScanTechnologiesRequest;

abstract class ApplicationAbstract
{

    public $url;
    public $host;
    public $applications;
    public $errors = false;
    public $applicationsByCategory;
    protected $siteAnatomy;
    protected $request;

    public function __construct(ScanTechnologiesRequest $request)
    {
        $this->host    = $request->getHost();
        $this->url     = $request->getUrl();
        $this->request = $request;
        if (get_class($this) != 'App\Engine\ScanModes\HistoricalMode') {
            $this->siteAnatomy = (new \App\Engine\SiteAnatomy($request));
        }
    }


    public function search()
    {
        $this->result();
        $this->sortApplicationByCategory();
        $this->clearAttributes();

        return $this;
    }

    abstract function result();

    public function sortApplicationByCategory()
    {

        if ($this->applications === null) {
            return false;
        }

        $json                  = json_decode(file_get_contents(app_path() . '/../node_modules/togglyzer/apps.json'));
        $categories            = $json->categories;
        $applicationByCategory = [];

        foreach ($categories as $category) {

            $categoryName = $category->name;
            if ( ! empty($this->applications)) {

                foreach ($this->applications as $appName => $app) {
                    $appCategories = $app->categories;

                    if (in_array($categoryName, $appCategories)) {
                        $applicationByCategory[$categoryName][] = $app;
                    }
                }
            }
        }


        return $this->applicationsByCategory = $applicationByCategory;
    }

    protected function clearAttributes()
    {
        unset($this->siteAnatomy);
        unset($this->request);
    }

}