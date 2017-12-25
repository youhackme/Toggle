<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanTechnologiesRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'  => 'required',
            'host' => 'string',
        ];
    }

    /**
     * The url to be scanned
     * @return array|string
     */
    public function getUrl()
    {
        $url = $this->input('url');

        $url = str_contains($url, ['http://', 'https://']) ? $url : 'http://' . $url;

        if ($this->method() == 'POST') {
            $url = urldecode($url);
        }

        return $url;
    }

    /**
     * The host name of the url to be scanned
     * @return mixed
     */
    public function getHost()
    {

        $uri = \App::make('Uri');

        return $uri->parseUrl(
            $this->input('url')
        )->host->host;
    }

    public function getHtml()
    {
        return $this->input('html');
    }

    /**
     * The environment variables
     * @return array|string
     */
    public function getEnvironment()
    {
        return $this->input('environment');
    }

    /**
     * The headers to be scanned
     * @return array|string
     */
    public function getHeaders()
    {
        return $this->input('headers');
    }


    /**
     * The source ip of this request
     * @return string
     */
    public function getIp()
    {
        return $this->ip();
    }

    public function getStatus()
    {
        return 200;
    }


}
