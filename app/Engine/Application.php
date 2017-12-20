<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 08/10/2017
 * Time: 14:39
 */

namespace App\Engine;

use GuzzleHttp\Client;
use Request;

class Application
{
    /**
     * What category should be displayed as main application?
     * @var array
     */
    public $mainApplications = ['CMS', 'Ecommerce', 'Message Boards'];

    /**
     * response from togglyzer result
     * @var
     */
    public $response;


    /**
     * Analyse data and find out what technologies is being used by a site
     * @return mixed
     */
    public function analyze()
    {
        $url         = Request::input('url');
        $html        = Request::input('html') ?? null;
        $environment = Request::input('environment') ?? null;
        $headers     = Request::input('headers') ?? null;

        $responseFromExternalScan = $this->externalScan([
            'url' => $url,
        ]);


        $externalTechnologies = [];
        //If there's no error
        if ( ! isset($responseFromExternalScan->error)) {
            $externalTechnologies = $technologies = $response = $responseFromExternalScan->technologies->applications;
        }

        $internalTechnologies = [];

        if (isset($html)) {
            $responseFromInternalScan = $this->internalScan([
                'url'         => $url,
                'html'        => $html,
                'environment' => $environment,
                'headers'     => $headers,
                'status'      => 200,
            ]);

            if ( ! isset($responseFromInternalScan->error)) {
                $internalTechnologies = $response = $responseFromInternalScan->technologies->applications;
            }
        }


        // Contains duplicate technlogies when combining offline and online scan
        $technologies = array_merge((array)$internalTechnologies, (array)$externalTechnologies);

        //Make technology list unique
        $uniqueApplications = [];
        if ( ! empty($technologies)) {
            foreach ($technologies as $technology) {
                $applicationName                      = $technology->name;
                $uniqueApplications[$applicationName] = $technology;

            }
        }


        // No result found for internal or external technologies

        if (empty($technologies)) {
            $response['error'] = 'Unfortunately, no technologies found for your query.';

            return $response;
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


        // For each technology detected
        foreach ($response->technologies->applications as $name => &$application) {
            $application->poweredBy = false;
            //Remove every category that is defined as main application
            foreach ($this->mainApplications as $mainApplication) {

                if (array_search($mainApplication, $application->categories) !== false) {
                    // Add this technology as the main application
                    $application->poweredBy = true;
                }
            }
        }


        $this->response = $response;

        if (isset($html)) {
            $this->saveToElastic(['origin' => 'chrome']);
        } else {
            $this->saveToElastic(['origin' => 'web']);
        }

        return (Array)$this->response->technologies->applications;

    }

    /**
     * Run a real-time scan of the url
     *
     * @param $params
     *
     * @return mixed
     */
    public function externalScan($params)
    {
        // Fetch result from external call
        $responseFromExternalScan = (new Client())->request(
            'GET',
            env('APP_URL') . '/site/?url=' . $params['url']
        );

        return json_decode($responseFromExternalScan->getBody()->getContents());

    }

    /**
     * Run an offline scan without invoking the actual site.
     *
     * @param $params
     *
     * @return mixed
     */
    public function internalScan($params)
    {
        //Fetch result from internal togglyzer engine
        $responseFromInternalScan = (
        new Client()
        )->request('POST', env('APP_URL') . '/site/ScanOfflineMode',
                [
                    'form_params' => [
                        'url'         => $params['url'],
                        'html'        => $params['html'],
                        'environment' => $params['environment'],
                        'headers'     => $params['headers'],
                        'status'      => 200,
                    ],
                ]);


        return json_decode($responseFromInternalScan->getBody()->getContents());

    }


    /**
     * Save result to ES
     *
     * @param $extraData
     *
     * @return mixed
     */
    private function saveToElastic($extraData)
    {

        $url = Request::input('url');

        if (Request::method() == 'POST') {
            $url = urldecode(Request::input('url'));
        }
        $uri = \App::make('Uri');


        $dsl                = [];
        $response           = unserialize(serialize($this->response->technologies));
        $currentTime        = \Carbon\Carbon::now();
        $now                = $currentTime->toDateTimeString();
        $dsl['url']         = $url;
        $dsl['host']        = $uri->parseUrl(
            $dsl['url']
        )->host->host;
        $dsl['clientIp']    = \Request::ip();
        $dsl['origin']      = $extraData['origin'];
        $dsl['environment'] = env('APP_ENV');
        $dsl['createdOn']   = $now;

        if ($response->applications['WordPress']->theme !== false) {
            $themesDetail                               = $response->applications['WordPress']->theme;
            $response->applications['WordPress']->theme = array_keys((array)$themesDetail);
        } else {
            unset($response->applications['WordPress']->theme);
        }

        if (empty($response->applications['WordPress']->plugins)) {
            unset($response->applications['WordPress']->plugins);
        }


        $dsl['technologies'] = array_values($response->applications);

        $data = [
            'body'  => $dsl,
            'index' => 'toggle',
            'type'  => 'technologies',

        ];

        return \Elasticsearch::index($data);
    }


}