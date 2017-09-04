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

        $site = str_replace(' ', '%20', $site);

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


    public function cache()
    {
        $url = \Request::get('url');
        $url = str_replace(' ', '%20', $url);

        if (Redis::EXISTS('site:' . $url)) {


            $datas = json_decode(Redis::get('site:' . $url), true);


            foreach ($datas as $key => $value) {

                $this->$key = $value;
            }

            return response()->json($this);
        }

        \Bugsnag::notifyError('Error', json_encode($this));

        return response()->json(['error' => 'Unable to find this key in redis.']);
    }
}
