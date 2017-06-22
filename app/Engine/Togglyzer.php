<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 20/06/2017
 * Time: 11:01
 */

namespace App\Engine;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class Togglyzer
 * @package App\Engine
 */
class Togglyzer
{
    /**
     * @var
     */
    public $siteAnatomy;

    /**
     * @var
     */
    public $technology;

    /**
     * Togglyzer constructor.
     *
     * @param $siteAnatomy
     */
    public function __construct(SiteAnatomy $siteAnatomy)
    {

        $this->siteAnatomy = $siteAnatomy;

        // Make sure we have an html object
        // Make sure we have a env object
        // Then execute it through wappalyser js
        //$this->technology = $togglyzerResult;

    }

    public function check()
    {
        $wappalyzerPath = app_path() . '/../node_modules/wappalyzer/index.js';
        //echo "Togglyzing through {$this->siteAnatomy->url}";
        $wappylyzerCommand = 'node ' . $wappalyzerPath . ' ' . $this->siteAnatomy->url;

        $process = new Process($wappylyzerCommand);
        $process->run();

        // executes after the command finishes
        if ( ! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $response = json_decode($process->getOutput());

        return $response;
    }

}