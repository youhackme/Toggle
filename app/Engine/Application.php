<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 08/10/2017
 * Time: 14:39
 */

namespace App\Engine;

use GuzzleHttp\Client;


class Application
{
    /**
     * What category should be displayed as main application?
     * @var array
     */
    public $mainApplications = ['CMS', 'Ecommerce', 'Message Boards'];

    /**
     * Instance of  Illuminate\Http\Request
     * @var
     */
    public $request;

    /**
     * response from togglyzer result
     * @var
     */
    public $response;

    /**
     * Application constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * Analyse data and find out what technologies is being used by a site
     * @return mixed
     */
    public function analyze()
    {

        $debug = $this->request->input('debug');
        $debug = is_null($debug) ? false : true;

        $url         = $this->request->input('url');
        $html        = $this->request->input('html');
        $environment = $this->request->input('environment');
        $headers     = $this->request->input('headers');

        $responseFromExternalScan = $this->externalScan([
            'url' => $url,
        ]);


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
            $internalTechnologies     = $response = $responseFromInternalScan->technologies->applications;

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


        $poweredBy = [];
        // For each technology detected
        foreach ($response->technologies->applications as $name => $application) {
            //Remove every category that is defined as main application
            foreach ($this->mainApplications as $mainApplication) {

                if (array_search($mainApplication, $application->categories) !== false) {
                    // Add this technology as the main application
                    $poweredBy[] = $application->name . ' ' . $application->version;
                    // Do not consider the main application as a technology as from now
                    unset($response->technologies->applications[$name]);
                }
            }
        }

        // Well, main application is not WordPress? Then define the main application from togglyzer
        if ( ! $response->application) {

            $response->application = $poweredBy;
        }

        // Make Pretty Url before display
        $uri = \App::make('Uri');

        $response->technologies->url = $uri->parseUrl(
            urldecode($response->technologies->url)
        )->host->host;

        // Group list of technologies by category
        $applicationByCategory = $this->sortApplicationByCategory($response);

        if ( ! empty($applicationByCategory)) {
            $response->technologies->applications = $applicationByCategory;
        }

        return $response;
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
     *
     * Group technologies by category
     *
     * @param $response
     *
     * @return array
     */
    public function sortApplicationByCategory($response)
    {
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

        return $applicationByCategory;
    }

}