<?php

namespace App\Http\Controllers;

use App\Engine\LiveTechnologyBuilder;
use App\Engine\SiteAnatomy;
use App\Engine\TechnologyDirector;
use App\Engine\Togglyzer;
use App\Http\Requests\ScanTechnologiesRequest;
use Bugsnag\Report;
use Illuminate\Support\Facades\Redis;
use Request;


class SiteController extends Controller
{
    /**
     * Discover whether this site is using WordPress or not.
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function detect(ScanTechnologiesRequest $request)
    {

        $siteAnatomy = (new \App\Engine\SiteAnatomy($request));

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


            \Bugsnag::notifyError('Connection Failed', "Failed to connect to " . $request->getUrl(),
                function (Report $report) use ($siteAnatomy) {
                    $report->setSeverity('error');
                    $report->setMetaData([
                        'filename' => $siteAnatomy->errors(),
                    ]);
                });

            return response()->json([
                'error' => 'Failed to connect to ' . $request->getUrl(),
            ]);
        }
    }


    /**
     *  Fetch Cached result from redis
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cache(ScanTechnologiesRequest $request)
    {
        $url = $request->getUrl();

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
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detectTechnologyOfflineMode(ScanTechnologiesRequest $request)
    {

        $site = $request->getUrl();

        $siteAnatomy = (new SiteAnatomy($request));

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
     * @param ScanTechnologiesRequest $request
     *
     * @return $this
     */
    public function scanFromWeb(ScanTechnologiesRequest $request)
    {

        //$site = new Technologies($request);

        // $fullScan = false;

        //if ( ! $site->alreadyScanned()) {
        // $fullScan             = true;
        $response = (new TechnologyDirector(new LiveTechnologyBuilder($request)))->build();

        //}

        //$responseFromCachedScan = (new TechnologyDirector(new CachedTechnologyBuilder($request)))->build();

        //if ($fullScan === true) {
        //Synthesize response
        //     $response = new ResponseSynthetiser($responseFromLiveScan, $responseFromCachedScan);
        // } else {
        //    $response = $responseFromCachedScan;
        // }

        if (isset($response->applications['error'])) {

            return view('website.error')
                ->with('response', $response);
        }


        return view('website.result')
            ->with('response', $response);
    }


    public function test()
    {
        dd('lol');
    }


}
