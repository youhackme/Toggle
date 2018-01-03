<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:07
 */

namespace App\Engine\ScanModes;

use App\Engine\Togglyzer;


class OfflineMode extends \App\Engine\ApplicationScanAbstract
{


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

        $otherTechnologies = $this->searchForOtherTechnologies();


        if ( ! empty($otherTechnologies)) {

            foreach ($otherTechnologies as $technology) {
                $apps->add($technology);
            }
        }

        $this->applications = $apps->all();


        return $this;
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


}