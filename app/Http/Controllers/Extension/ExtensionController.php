<?php

namespace App\Http\Controllers\Extension;

use App\Engine\CachedTechnologyBuilder;
use App\Engine\Elastic\Technologies;
use App\Engine\LiveTechnologyBuilder;
use App\Engine\TechnologyDirector;
use App\Http\Controllers\Controller;
use DB;
use Request;

class ExtensionController extends Controller
{

    public function scan(Request $request)
    {
        $site = new Technologies($request);


        if ($site->alreadyScanned()) {
            $technologyBuilder = new CachedTechnologyBuilder($request);
        } else {
            $technologyBuilder = new LiveTechnologyBuilder($request);
        }

        $response = (new TechnologyDirector($technologyBuilder))->build();
        

        return view('extension/index')
            ->with('response', $response);

    }
}
