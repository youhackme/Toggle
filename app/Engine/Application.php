<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 08/10/2017
 * Time: 14:39
 */

namespace App\Engine;

use App\Http\Requests\ScanTechnologiesRequest;
use GuzzleHttp\Client;
use Request;

class Application
{
    /**
     * What category should be displayed as main application?
     * @var array
     */
    public $mainApplications = ['CMS', 'Ecommerce', 'Message Boards'];

    public $request;

    /**
     * response from togglyzer result
     * @var
     */
    public $response;

    public function __construct(ScanTechnologiesRequest $request)
    {
        $this->request = $request;
    }


    /**
     * Analyse data and find out what technologies is being used by a site
     * @return mixed
     */
    public function analyze()
    {

        $responseFromExternalScan = $this->externalScan([
            'url' => $this->request->getUrl(),
        ]);


        $externalTechnologies = [];
        //If there's no error
        if ( ! isset($responseFromExternalScan->error)) {
            $externalTechnologies = $technologies = $response = $responseFromExternalScan->technologies->applications;
        }

        $internalTechnologies = [];

        if ( ! is_null($this->request->getHtml())) {
            $responseFromInternalScan = $this->internalScan([
                'url'         => $this->request->getUrl(),
                'html'        => $this->request->getHtml(),
                'environment' => $this->request->getEnvironment(),
                'headers'     => $this->request->getHeaders(),
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

        if ( ! is_null($this->request->getHtml())) {
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

        $dsl                = [];
        $response           = unserialize(serialize($this->response->technologies));
        $dsl['url']         = $this->request->getUrl();
        $dsl['host']        = $this->request->getHost();
        $dsl['clientIp']    = $this->request->getIp();
        $dsl['origin']      = $extraData['origin'];
        $dsl['environment'] = env('APP_ENV');
        $dsl['createdOn']   = \Carbon\Carbon::now()->toDateTimeString();


        if (isset($response->applications['WordPress']->theme)) {
            if ($response->applications['WordPress']->theme !== false) {
                $themesDetail                               = $response->applications['WordPress']->theme;
                $response->applications['WordPress']->theme = array_keys((array)$themesDetail);
            } else {
                unset($response->applications['WordPress']->theme);
            }
        }
        if (isset($response->applications['WordPress']->theme)) {
            if (empty($response->applications['WordPress']->plugins)) {
                unset($response->applications['WordPress']->plugins);
            }
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