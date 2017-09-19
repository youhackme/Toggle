<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:39
 */

namespace App\Engine\Bot\Driver;

use App;
use App\Engine\Bot\BotInterface;

class Curl implements BotInterface
{


    public $goutteClient;

    public function request($url)
    {
        //echo 'Scrape ' . $url . ' using Curl via Guzzle';
        $site = str_contains($url, ['http://', 'https://']) ? $url : 'http://' . $url;

        $this->goutteClient = App::make('goutte');

        try {
            $this->crawler = $this->goutteClient->request(
                'GET',
                $site
            );

            return $this;


        } catch (\GuzzleHttp\Exception\TransferException $e) {
            echo $e->getMessage();

            return $e->getMessage();
        }
    }

    public function headers()
    {
        return $this->goutteClient->getResponse()->getHeaders();
    }


    /**
     * @return mixed
     */
    public function cookies()
    {
        return $this->goutteClient->getCookieJar();
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->goutteClient->getResponse()->getStatus();
    }

    /**
     * @return mixed
     */
    public function url()
    {
        return $this->crawler->getBaseHref();
    }

    /**
     * @return mixed
     */
    public function host()
    {
        return parse_url($this->url(), PHP_URL_HOST);
    }

    /**
     * @return mixed
     */
    public function html()
    {
        return $this->goutteClient->getResponse()->getContent();
    }

    public function environment()
    {
        return [];
    }
}