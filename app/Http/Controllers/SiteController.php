<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    /**
     * Discover whether this site is using WordPress or not.
     *
     * @param $site
     */
    public function detect($site)
    {
        $siteAnatomy = (new \App\Engine\SiteAnatomy($site));
        $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

        if ($application->isWordPress()) {
            echo $application->details();
        } else {
            echo 'Sadly, you are not using WordPress';
        }
    }
}
