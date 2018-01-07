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

        $apps = new \App\Engine\ApplicationComponents\Applications();

        //Do u have any html? yes? then scan offlinemode

        if ( ! is_null($this->request->getHtml())) {
            $responseOfflineMode = (new ScanTechnologies($this->request))
                ->setOptions(['mode' => 'offline'])
                ->result();

            $applicationsFromOfflineMode = $responseOfflineMode->applications;

            if ( ! is_null($applicationsFromOfflineMode)) {
                foreach ($applicationsFromOfflineMode as $technology) {
                    $apps->add($technology);
                }
            }
        };


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


            if ( ! is_null($applicationsFromLiveSearch)) {
                foreach ($applicationsFromLiveSearch as $technology) {
                    $apps->add($technology);
                }
            }

            if ( ! is_null($applicationsFromLiveSearch)) {
                foreach ($applicationsFromHistoricalSearch as $technology) {
                    $apps->add($technology);
                }
            }
            //$applications = $apps->unique();


            // Then merge it
        } else {
            //echo('This url has already beeen scanned ' . $this->request->getUrl());
            // Well this specific url has already been scanned before, no need to do a live search again.
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $responseHistoricalMode->searchForHistoricalTechnologies();

            $applications = $applicationsFromHistoricalSearch;

            if ( ! is_null($applications)) {
                foreach ($applications as $technology) {
                    $apps->add($technology);
                }
            }
        }
        // Then fetch cached data by host name
        // Merge it with the live search.
        $this->applications = $apps->unique();

        return $this;
    }


}