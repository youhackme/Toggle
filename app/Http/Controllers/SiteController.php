<?php

namespace App\Http\Controllers;


class SiteController extends Controller
{


    public function detect($site)
    {

        $siteAnatomy = (new \App\Engine\SiteAnatomy($site));
        $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));
        
        if ($application->isWordPress()) {
            echo $application->details();
        } else {
            echo "Sadly, you are not using WordPress";
        }


    }
}
