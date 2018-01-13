<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:39
 */

namespace App\Engine\Bot\Driver;


use App\Engine\Bot\BotInterface;
use App\Http\Requests\ScanTechnologiesRequest;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PhantomJS implements BotInterface
{

    public $response;

    /**
     * @param ScanTechnologiesRequest $request
     *
     * @return $this
     */
    public function request(ScanTechnologiesRequest $request)
    {
        $url         = $request->getUrl();
        $scraperPath = app_path() . '/Engine/Bot/scraper.js';
        $command     = 'phantomjs --ignore-ssl-errors=true --load-images=false ' . $scraperPath . ' ' . "'" . $url . "'";
        $process     = new Process($command);
        $process->run();

        // executes after the command finishes
        if ( ! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->response = json_decode($process->getOutput());

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
        $headers          = json_decode($this->response->headers);
        $blacklistHeaders = ['Expires', 'Cache-Control'];
        foreach ($headers as $header) {
            $headerName  = $header->name;
            $headerValue = $header->value;
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
        return isset($this->response->status) ? $this->response->status : null;
    }

    /**
     * The host name
     * @return mixed
     */
    public function host()
    {

        $uri = \App::make('Uri');

        return $uri->parseUrl(
            $this->url()
        )->host->host;


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