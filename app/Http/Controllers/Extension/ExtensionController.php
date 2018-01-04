<?php

namespace App\Http\Controllers\Extension;


use App\Engine\ScanTechnologies;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScanTechnologiesRequest;
use DB;
use Request;

class ExtensionController extends Controller
{

    public function scan(ScanTechnologiesRequest $request)
    {


        $response = (new ScanTechnologies($request))
            ->setOptions(['mode' => 'god'])
            ->search();


        if (empty($response->errors)) {

            return view('extension.index')
                ->with('response', $response);
        }


    }
}
