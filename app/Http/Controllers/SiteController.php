<?php

namespace App\Http\Controllers;

use App\Engine\Application;
use App\Engine\Togglyzer;
use Bugsnag\Report;
use Illuminate\Support\Facades\Redis;
use Request;

class SiteController extends Controller
{
    /**
     * Discover whether this site is using WordPress or not.
     *
     * @return string
     */
    public function detect()
    {

        $site = Request::get('url');

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

            //  \Bugsnag::notifyError("Failed to connect to $site", json_encode($siteAnatomy->errors()));

            \Bugsnag::notifyError('Connection Failed', "Failed to connect to $site",
                function (Report $report) use ($siteAnatomy) {
                    $report->setSeverity('error');
                    $report->setMetaData([
                        'filename' => $siteAnatomy->errors(),
                    ]);
                });

            return response()->json([
                'error' => 'Failed to connect to ' . $site,
            ]);
        }
    }

    /**
     * Fetch Cached result from redis
     * @return \Illuminate\Http\JsonResponse
     */
    public function cache()
    {
        $url = Request::get('url');

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

    /**
     * Detect technology by using togglyzer engine only. No external call. Period.
     */
    public function detectTechnologyOfflineMode()
    {

        $site = Request::get('url');

        $requestInfo = Request::all();
        $siteAnatomy = (new \App\Engine\SiteAnatomy($site, $requestInfo));

        if ( ! $siteAnatomy->errors()) {

            return response()->json([
                'technologies' => (new Togglyzer($siteAnatomy))->check(),
            ]);

        } else {

            \Bugsnag::notifyError('Error', json_encode($siteAnatomy->errors()));

            return response()->json([
                'error' => 'Unable to simulate crawling in offline mode for ' . $site,
            ]);
        }

    }


    /**
     * Public end-point for detecting through web
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this
     */
    public function scanFromWeb(\Illuminate\Http\Request $request)
    {

        $application = new Application($request);
        $response    = $application->analyze();

        if (is_array($response) && ($response['error'])) {

            return view('website.error')
                ->with('response', $response);
        }

        $application->convertToElastic(['origin'=>'web']);


        return view('website.result')
            ->with('response', $response);
    }


}
