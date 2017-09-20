<?php

namespace App\Http\Controllers\Extension;

use App\Http\Controllers\Controller;
use DB;
use GuzzleHttp\Client;
use Request;


class ExtensionController extends Controller
{
    public function scan()
    {

        $url   = Request::post('url');
        $debug = Request::post('debug');
        $debug = is_null($debug) ? false : true;

        $html        = Request::post('html');
        $environment = Request::post('environment');
        $headers     = Request::post('headers');


        // Fetch result from external call
        $responseFromExternalScan = (new Client())->request('GET', env('APP_URL') . '/site/?url=' . $url);
        $responseFromExternalScan = json_decode($responseFromExternalScan->getBody()->getContents());


        //Fetch result from internal togglyzer engine
        $responseFromInternalScan = (new Client())->request('POST', env('APP_URL') . '/site/ScanOfflineMode', [
            'form_params' => [
                'url'         => $url,
                'html'        => $html,
                'environment' => $environment,
                'headers'     => $headers,
                'status'      => 200,
            ],
        ]);

        $responseFromInternalScan = json_decode($responseFromInternalScan->getBody()->getContents());

        //TODO: Merge the two technologies result
        $externalTechnologies = $responseFromExternalScan->technologies->applications;
        $internalTechnologies = $responseFromInternalScan->technologies->applications;


        $result = array_merge((array)$internalTechnologies, (array)$externalTechnologies);

        $uniqueApplications = [];
        foreach ($result as $application) {
            $applicationName                      = $application->name;
            $uniqueApplications[$applicationName] = $application;
        }
        dd($uniqueApplications);

        return view('plugin/index')
            ->with('response', $response)
            ->with('debug', $debug);


    }
}
