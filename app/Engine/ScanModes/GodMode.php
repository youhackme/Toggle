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

        $responseHistoricalMode = new HistoricalMode($this->request);

        if ( ! $responseHistoricalMode->alreadyScanned()) {
            //echo('This url has NOT been scanned yet. ' . $this->request->getUrl());
            // Then fetch live data

            $responseOnlineMode         = new OnlineMode($this->request);
            $applicationsFromLiveSearch = $responseOnlineMode->applications;
            // Then fetch historical data by host
            $applicationsFromHistoricalSearch = $responseHistoricalMode->searchForHistoricalTechnologies();


            $apps = new \App\Engine\Apps();

            foreach ($applicationsFromLiveSearch as $technology) {
                $apps->add($technology);
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