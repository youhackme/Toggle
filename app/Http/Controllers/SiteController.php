<?php

namespace App\Http\Controllers;


class SiteController extends Controller
{


    public function detect($site)
    {

        $siteAnatomy = (new \App\Engine\SiteAnatomy($site));


        $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));
        if ($application->isWordPress()) {
            echo json_encode(
                [
                    'wordpress' => true,
                    'theme'     => $application->theme(),
                    'plugins'   => $application->plugins(),
                ]
            );
        } else {
            echo "Sadly, you are not using WordPress";
        }


    }
}
