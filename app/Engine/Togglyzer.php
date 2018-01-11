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

    }

    public function check()
    {

        $wappalyzerPath = app_path() . '/../node_modules/togglyzer/index.js';

        $wappylyzerCommand = 'node ' . $wappalyzerPath . ' ' . env('APP_URL') . '/cache?url=' . urlencode($this->siteAnatomy->url);

        $process = new Process($wappylyzerCommand);
        $process->run();


        // executes after the command finishes
        if ( ! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $response = json_decode($process->getOutput());

        $response->url = urldecode($response->url);
        if (isset($response->applications)) {
            foreach ($response->applications as &$application) {
                $application->icon = env('APP_URL') . '/storage/icons/' . $application->icon;
            }
        }

        return $response;
    }

}