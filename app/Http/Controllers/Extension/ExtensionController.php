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
        $externalTechnologies     = $technologies = $responseFromExternalScan->technologies->applications;
        
        if (isset($html)) {


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

            $internalTechnologies = $responseFromInternalScan->technologies->applications;

            $technologies = array_merge((array)$internalTechnologies, (array)$externalTechnologies);

        }

        $uniqueApplications = [];
        foreach ($technologies as $technology) {
            $applicationName                      = $technology->name;
            $uniqueApplications[$applicationName] = $technology;
        }

        $responseFromExternalScan->technologies->applications = $uniqueApplications;


        return view('plugin/index')
            ->with('response', $responseFromExternalScan)
            ->with('debug', $debug);


    }
}
