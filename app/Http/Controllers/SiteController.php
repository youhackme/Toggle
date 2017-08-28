<?php

namespace App\Http\Controllers;

use App\Engine\Togglyzer;

class SiteController extends Controller
{
    /**
     * Discover whether this site is using WordPress or not.
     *
     * @return string
     */
    public function detect()
    {
        $site = \Request::get('url');

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


        } else {

            \Bugsnag::notifyError('Error', json_encode($siteAnatomy->errors()));

            return response()->json([
                'error' => 'Failed to connect to ' . $site,
            ]);
        }
    }
}
