<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use DB;
use GuzzleHttp\Client;


class PluginController extends Controller
{
    public function scan()
    {

        $site     = \Request::get('url');
        $client   = new Client();
        $response = $client->request('GET', env('APP_URL') . '/site/?url=' . $site);
        $response = json_decode($response->getBody()->getContents());

        return view('plugin/index')
            ->with('response', $response);
        
    }
}