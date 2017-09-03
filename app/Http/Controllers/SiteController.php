<?php

namespace App\Http\Controllers;

use App\Engine\Togglyzer;
use Illuminate\Support\Facades\Redis;

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


    public function cache(){
        $url     = \Request::get('url');

        if (Redis::EXISTS('site:' . $url)) {


            $datas = json_decode(Redis::get('site:' . $url), true);


            foreach ($datas as $key => $value) {

                $this->$key = $value;
            }
            return response()->json($this);

           // return json_encode($this);
        }
    }
}
