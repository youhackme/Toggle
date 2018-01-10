<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 18/09/2017
 * Time: 20:52
 */

namespace App\Engine\Bot\Driver;

use App\Engine\Bot\BotInterface;
use App\Http\Requests\ScanTechnologiesRequest;

class BrowserSimulator implements BotInterface
{

    public $response;


    /**
     * @param ScanTechnologiesRequest $request
     *
     * @return $this
     */
    public function request(ScanTechnologiesRequest $request)
    {

        $this->response = (Object)[
            'html'    => $request->getHtml(),
            'host'    => $request->getHost(),
            'url'     => $request->getUrl(),
            'headers' => $request->getHeaders() ?? [],
            'env'     => explode(' ', $request->getEnvironment()),
            "status"  => $request->getStatus(),
        ];

        return $this;

    }

    /**
     * Environment founds in global namespace
     * @return mixed
     */
    public function environment()
    {
        return isset($this->response->env) ? array_unique($this->response->env) : [];
    }

    /**
     * Response Headers
     * @return array
     */
    public function headers()
    {
        $filteredHeaders = [];

        if (empty((array)$this->response->headers)) {
            return $filteredHeaders;
        }
        $headers          = $this->response->headers;
        $blacklistHeaders = ['Expires', 'Cache-Control'];


        foreach ($headers as $headerName => $headerValue) {
            $headerValue = [$headerValue];
            
            if ( ! in_array($headerName, $blacklistHeaders)) {
                $headerValue = explode(',', $headerValue);
            }

            $filteredHeaders[$headerName] = $headerValue;
        }

        return $filteredHeaders;
    }

    /**
     * Response cookies
     */
    public function cookies()
    {
        return isset($this->response->cookies) ? $this->response->cookies : [];
    }

    /**
     * Response status
     * @return mixed
     */
    public function status()
    {
        return $this->response->status;
    }

    /**
     * The host name
     * @return mixed
     */
    public function host()
    {
        return parse_url(urldecode($this->url()), PHP_URL_HOST);
    }

    /**
     * Url requested
     * @return mixed
     */
    public function url()
    {
        return $this->response->url;
    }

    /**
     * Raw HTML
     * @return mixed
     */
    public function html()
    {
        return $this->response->html;
    }


}