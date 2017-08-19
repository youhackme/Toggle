<?php

namespace App\Http\Controllers;

use App\Engine\Togglyzer;

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

            return response()->json([
                'application'  => false,
                'version'      => false,
                'theme'        => false,
                'plugins'      => false,
                'technologies' => (new Togglyzer($siteAnatomy))->check(),
            ]);


        }
    }
}
