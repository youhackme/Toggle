<?php

namespace App\Http\Controllers\Extension;

use App\Engine\Application;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{

    public function scan(Request $request)
    {
        $application = new Application($request);
        $response    = $application->analyze();

        $application->convertToElastic(['origin' => 'chrome']);

        return view('extension/index')
            ->with('response', $response);

    }
}
