<?php

namespace App\Http\Controllers\Extension;

use App\Engine\Application;
use App\Http\Controllers\Controller;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{

    public function scanv2(Request $request)
    {
        $application = new Application($request);
        $response    = $application->analyze();


        return view('extension/indexV2')
            ->with('response', $response);

    }
}
