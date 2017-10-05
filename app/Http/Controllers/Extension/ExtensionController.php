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
        $externalTechnologies     = $technologies = [];
        //If there's no error
        if ( ! isset($responseFromExternalScan->error)) {
            $externalTechnologies = $technologies = $response = $responseFromExternalScan->technologies->applications;
        }


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

            $internalTechnologies = $response = $responseFromInternalScan->technologies->applications;

            $technologies = array_merge((array)$internalTechnologies, (array)$externalTechnologies);

        }


        $uniqueApplications = [];
        if ( ! empty($technologies)) {
            foreach ($technologies as $technology) {
                $applicationName                      = $technology->name;
                $uniqueApplications[$applicationName] = $technology;
            }
        }


        if ( ! isset($responseFromExternalScan->error)) {
            $responseFromExternalScan->technologies->applications = $uniqueApplications;
            $response                                             = $responseFromExternalScan;
        } else {

            $responseFromInternalScan->application                = false;
            $responseFromInternalScan->version                    = false;
            $responseFromInternalScan->theme                      = false;
            $responseFromInternalScan->plugins                    = false;
            $responseFromInternalScan->technologies->applications = $uniqueApplications;
            $response                                             = $responseFromInternalScan;
        }


        return view('extension/index')
            ->with('response', $response)
            ->with('debug', $debug);


    }

    public function scanv2()
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
        $externalTechnologies     = $technologies = [];
        //If there's no error
        if ( ! isset($responseFromExternalScan->error)) {
            $externalTechnologies = $technologies = $response = $responseFromExternalScan->technologies->applications;
        }


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

            $internalTechnologies = $response = $responseFromInternalScan->technologies->applications;

            $technologies = array_merge((array)$internalTechnologies, (array)$externalTechnologies);

        }


        $uniqueApplications = [];
        if ( ! empty($technologies)) {
            foreach ($technologies as $technology) {
                $applicationName                      = $technology->name;
                $uniqueApplications[$applicationName] = $technology;
            }
        }


        if ( ! isset($responseFromExternalScan->error)) {
            $responseFromExternalScan->technologies->applications = $uniqueApplications;
            $response                                             = $responseFromExternalScan;
        } else {

            $responseFromInternalScan->application                = false;
            $responseFromInternalScan->version                    = false;
            $responseFromInternalScan->theme                      = false;
            $responseFromInternalScan->plugins                    = false;
            $responseFromInternalScan->technologies->applications = $uniqueApplications;
            $response                                             = $responseFromInternalScan;
        }

        $json                  = json_decode(file_get_contents(app_path() . '/../node_modules/togglyzer/apps.json'));
        $categories            = $json->categories;
        $applicationByCategory = [];


        foreach ($categories as $category) {
            $categoryName = $category->name;
            if ( ! empty($response->technologies->applications)) {

                foreach ($response->technologies->applications as $appName => $app) {
                    $appCategories = $app->categories;


                    if (in_array($categoryName, $appCategories)) {
                        $applicationByCategory[$categoryName][] = $app;
                    }

                }

            }
        }

        if ( ! empty($applicationByCategory)) {
            $response->technologies->applications = $applicationByCategory;
        }

        return view('extension/indexV2')
            ->with('response', $response)
            ->with('debug', $debug);
    }
}
