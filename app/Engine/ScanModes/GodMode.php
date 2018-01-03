<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:07
 */

namespace App\Engine\ScanModes;

use App\Engine\ScanTechnologies;

class GodMode extends \App\Engine\ApplicationScanAbstract
{

    // Do an online search
    // Do an offline search (if it is from extension)
    // Do a historical search (from ES)


    public function result()
    {

        $responseHistoricalMode = (new ScanTechnologies($this->request))
            ->setOptions(['mode' => 'historical'])
            ->result();

        if ( ! $responseHistoricalMode->alreadyScanned()) {
            //echo('This url has NOT been scanned yet. ' . $this->request->getUrl());
            // Then fetch live data

            $responseOnlineMode = (new ScanTechnologies($this->request))
                ->setOptions(['mode' => 'online'])
                ->result();


            $applicationsFromLiveSearch = $responseOnlineMode->applications;
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $responseHistoricalMode->searchForHistoricalTechnologies();


            $apps = new \App\Engine\Applications();

            if ( ! is_null($applicationsFromLiveSearch)) {
                foreach ($applicationsFromLiveSearch as $technology) {
                    $apps->add($technology);
                }
            }


            foreach ($applicationsFromHistoricalSearch as $technology) {
                $apps->add($technology);
            }

            $applications = $apps->unique();


            // Then merge it
        } else {
            //echo('This url has already beeen scanned ' . $this->request->getUrl());
            // Well this specific url has already been scanned before, no need to do a live search again.
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $responseHistoricalMode->searchForHistoricalTechnologies();

            $applications = $applicationsFromHistoricalSearch;
        }
        // Then fetch cached data by host name
        // Merge it with the live search.
        $this->applications = $applications;

        return $this;
    }


}