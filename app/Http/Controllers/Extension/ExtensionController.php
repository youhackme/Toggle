<?php

namespace App\Http\Controllers\Extension;

use App\Http\Controllers\Controller;
use DB;
use GuzzleHttp\Client;


class ExtensionController extends Controller
{
    public function scan()
    {

        $site  = \Request::post('url');
        $debug = \Request::post('debug');
        $debug = is_null($debug) ? false : true;

        //$input = \Request::all();

        $client   = new Client();
        $response = $client->request('GET', env('APP_URL') . '/site/?url=' . $site);
        $response = json_decode($response->getBody()->getContents());

        return view('plugin/index')
            ->with('response', $response)
            ->with('debug', $debug);


    }
}
