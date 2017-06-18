<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:39
 */

namespace App\Engine\Bot;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class PhantomJS implements BotInterface
{

    /**
     * @param $url
     *
     * @return string
     */
    public function request($url)
    {
        $scraperPath = app_path() . '/Engine/Bot/scraper.js';
        echo 'Scrape ' . $url . ' using PhantomJS';

        $process = new Process('phantomjs ' . $scraperPath . ' ' . $url);
        $process->run();

        // executes after the command finishes
        if ( ! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();

    }

}