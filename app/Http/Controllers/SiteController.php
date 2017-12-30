<?php

namespace App\Http\Controllers;

use App\Engine\LiveTechnologyBuilder;
use App\Engine\ScanTechnologies;
use App\Engine\TechnologyDirector;
use App\Http\Requests\ScanTechnologiesRequest;
use Illuminate\Support\Facades\Redis;
use Request;

class SiteController extends Controller
{
    /**
     * Scan for technology live by initiating a request through the underlying headless browser
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function detectTechnologyOnlineMode(ScanTechnologiesRequest $request)
    {
        $result = (new ScanTechnologies($request))
            ->setOptions(['mode' => 'online'])
            ->search();

        if (empty($result->errors)) {

            return response()->json($result);
        }

        \Bugsnag::notifyError('Connection Failed', $result->errors,
            function (Report $report) use ($request) {
                $report->setSeverity('error');
            });

        return response()->json(['error' => $result->errors], 500);

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

        $result = (new ScanTechnologies($request))
            ->setOptions(['mode' => 'offline'])
            ->search();


        if (empty($result->errors)) {

            return response()->json($result);
        }

        \Bugsnag::notifyError('Connection Failed', $result->errors,
            function (Report $report) use ($request) {
                $report->setSeverity('error');
            });

        return response()->json(['error' => $result->errors], 500);

    }


    /**
     * Detect technology based on historical data saved in ES
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detectTechnologyHistoricalMode(ScanTechnologiesRequest $request)
    {
        $result = (new ScanTechnologies($request))
            ->setOptions(['mode' => 'historical'])
            ->search();

        if (empty($result->errors)) {

            return response()->json($result);
        }

        \Bugsnag::notifyError('Connection Failed', $result->errors,
            function (Report $report) use ($request) {
                $report->setSeverity('error');
            });

        return response()->json(['error' => $result->errors], 500);


    }


    /**
     * The most powerful way so far to detecmine technologies by combining
     * Online, offline and cached mode
     *
     * @param ScanTechnologiesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detectTechnologyGodMode(ScanTechnologiesRequest $request)
    {
        $result = (new ScanTechnologies($request))
            ->setOptions(['mode' => 'god'])
            ->result();
        if (empty($result->errors)) {

            return response()->json($result);
        }

        \Bugsnag::notifyError('Connection Failed', $result->errors,
            function (Report $report) use ($request) {
                $report->setSeverity('error');
            });

        return response()->json(['error' => $result->errors], 500);
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

        return response()->json(['error' => 'Unable to find this key in redis.'], 500);
    }

}
