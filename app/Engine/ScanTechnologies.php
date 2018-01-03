<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 25/12/2017
 * Time: 18:34
 */

namespace App\Engine;

use App\Engine\ScanModes\GodMode;
use App\Engine\ScanModes\HistoricalMode;
use App\Engine\ScanModes\OfflineMode;
use App\Engine\ScanModes\OnlineMode;
use App\Http\Requests\ScanTechnologiesRequest;

class ScanTechnologies
{


    public $applications;
    public $request;
    public $scan;

    public function __construct(ScanTechnologiesRequest $request)
    {
        $this->request = $request;
    }

    /**
     * mode = online - Make external request to site + scan raw data from POST
     * mode = offline - Scan raw data from POST
     *
     * @param $options
     *
     * @return $this
     */
    public function setOptions($options = ['mode' => 'online'])
    {

        switch ($options['mode']) {
            case 'online':
                $scan = new OnlineMode($this->request);
                break;
            case 'offline':
                $scan = new OfflineMode($this->request);
                break;
            case 'historical':
                $scan = new HistoricalMode($this->request);
                break;
            case 'god':
                $scan = new GodMode($this->request);
                break;
            default:
                $scan = new OnlineMode($this->request);
        }


        return $this->scan = $scan;
    }
    

}