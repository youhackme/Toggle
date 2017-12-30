<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:07
 */

namespace App\Engine\ScanModes;


class GodMode extends \App\Engine\ApplicationAbstract
{

    // Do an online search
    // Do an offline search (if it is from extension)
    // Do a historical search (from ES)


    public function result()
    {

        if ( ! $this->alreadyScanned()) {
            echo('This url has NOT been scanned yet. ' . $this->request->getUrl());
            // Then fetch live data
            $search = (new ScanTechnologies($this->request))
                ->setOptions(['mode' => 'online'])
                ->search();

            $applicationsFromLiveSearch = $search->applications;
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $this->searchForHistoricalTechnologies();


            $apps = new \App\Engine\Apps();

            foreach ($applicationsFromLiveSearch as $technology) {
                $apps->add($technology);
            }


            foreach ($applicationsFromHistoricalSearch as $technology) {
                $apps->add($technology);
            }

            $applications = $apps->unique();

            //dd($applicationsFromHistoricalSearch, $applicationsFromLiveSearch);
            // Then merge it
        } else {
            echo('This url has already beeen scanned ' . $this->request->getUrl());
            // Well this specific url has already been scanned before, no need to do a live search again.
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $this->searchForHistoricalTechnologies();

            $applications = $applicationsFromHistoricalSearch;
        }


        // Then fetch cached data by host name
        // Merge it with the live search.
        $this->applications = $applications;

        return $this;
    }

}