<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    /**
     * Discover whether this site is using WordPress or not.
     *
     * @param $site
     *
     * @return string
     */
    public function detect($site)
    {
        $siteAnatomy = (new \App\Engine\SiteAnatomy($site));
        if ( ! $siteAnatomy->errors()) {
            $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

            if ($application->isWordPress()) {
                return $application->details();
            }

            return 'Sadly, you are not using WordPress';
        }
    }
}
