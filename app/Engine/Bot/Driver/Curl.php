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
use App\Http\Requests\ScanTechnologiesRequest;

class Curl implements BotInterface
{


    public $goutteClient;
    public $crawler;

    public function request(ScanTechnologiesRequest $request)
    {
        $url = $request->getUrl();

        $this->goutteClient = App::make('goutte');

        try {
            $this->crawler = $this->goutteClient->request(
                'GET',
                $url
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