<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 18/09/2017
 * Time: 20:52
 */

namespace App\Engine\Bot\Driver;

use App\Engine\Bot\BotInterface;

class BrowserSimulator implements BotInterface
{

    public $response;


    /**
     * @param $requestInfo
     *
     * @return $this
     */
    public function request($requestInfo)
    {

        $this->response = (Object)[
            'html'     => $requestInfo['html'],
            'host' => $requestInfo['url'],
            'url'      => $requestInfo['url'],
            'headers'  => $requestInfo['headers'],
            'env'      => explode(' ', $requestInfo['environment']),
            "status"   => $requestInfo['status'],
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

            if ( ! in_array($headerName, $blacklistHeaders)) {
                $headerValue = explode(',', $headerValue);
            } else {
                $headerValue = [$headerValue];
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
     * Url requested
     * @return mixed
     */
    public function url()
    {
        return $this->response->url;
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
     * Raw HTML
     * @return mixed
     */
    public function html()
    {
        return $this->response->html;
    }


}