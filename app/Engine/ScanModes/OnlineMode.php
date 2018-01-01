<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:06
 */

namespace App\Engine\ScanModes;

use App\Engine\Togglyzer;

class OnlineMode extends \App\Engine\ApplicationAbstract
{


    /**
     * Check if there is any sign of WordPress under the hood for this site
     * @return string
     */
    public function searchForwordPress()
    {
        $application = (new \App\Engine\WordPress\WordPress($this->siteAnatomy))->details();

        return $application;
    }


    /**
     * Scan for any other technologies running under the hood.
     * @return array
     */
    public function searchForOtherTechnologies()
    {
        $applications      = [];
        $otherTechnologies = (new Togglyzer($this->siteAnatomy))->check();
        if (isset($otherTechnologies->applications)) {
            foreach ($otherTechnologies->applications as $application) {

                if ($application->name != 'WordPress') {

                    $app = (new \App\Engine\App())
                        ->setName($application->name)
                        ->setConfidence($application->confidence)
                        ->setVersion($application->version)
                        ->setIcon($application->icon)
                        ->setWebsite($application->website)
                        ->setCategories($application->categories);

                    $applications[] = $app;
                }

            }
        }

        return $applications;
    }


    /**
     * @return $this
     */
    public function result()
    {

        if ( ! empty($this->siteAnatomy->errors())) {
            $this->errors = $this->siteAnatomy->errors();

            return $this;
        }

        $apps = new \App\Engine\Apps();

        //External scanning
        $appWordPress = $this->searchForwordPress();
        if ($appWordPress !== false) {
            $apps->add($appWordPress);
        }


        $otherTechnologies = $this->searchForOtherTechnologies();


        if ( ! empty($otherTechnologies)) {

            foreach ($otherTechnologies as $technology) {
                $apps->add($technology);
            }
        }

        $this->applications = $apps->all();
        $this->saveToElastic();


        return $this;
    }


    /**
     *  Filter results before saving to ES
     * @return mixed
     */
    private function saveToElastic()
    {

        $applications = unserialize(serialize($this->applications));

        $applicationsFiltered = collect($applications)->each(function ($app) {

            unset($app->poweredBy, $app->icon, $app->website);

            if ( ! is_null($app->themes)) {
                collect($app->themes)->each(function ($theme) {
                    unset($theme->screenshotHash, $theme->screenshotUrl, $theme->description);
                });
            }

            if ( ! is_null($app->plugins)) {
                collect($app->plugins)->each(function ($plugin) {
                    unset($plugin->description);
                });
            }

            return $app;
        });


        $dsl                 = [];
        $dsl['url']          = $this->request->getUrl();
        $dsl['host']         = $this->request->getHost();
        $dsl['clientIp']     = $this->request->getIp();
        $dsl['origin']       = $this->request->getOrigin();
        $dsl['environment']  = env('APP_ENV');
        $dsl['createdOn']    = \Carbon\Carbon::now()->toDateTimeString();
        $dsl['technologies'] = $applicationsFiltered;


        $data = [
            'body'  => $dsl,
            'index' => 'toggle',
            'type'  => 'technologies',
        ];


        return \Elasticsearch::index($data);
    }


}