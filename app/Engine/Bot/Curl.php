<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:39
 */

namespace App\Engine\Bot;

use App;

class Curl implements BotInterface
{


    public $goutteClient;

    public function request($url)
    {
        echo 'Scrape ' . $url . ' using Curl via Guzzle';
        $site = str_contains($url, ['http://', 'https://']) ? $url : 'http://' . $url;

        $this->goutteClient = App::make('goutte');

        try {
            $this->crawler = $this->goutteClient->request(
                'GET',
                $site
            );

            return json_encode(
                [
                    'html'    => $this->goutteClient->getResponse()->getContent(),
                    'headers' => $this->getHeaders(),
                ]
            );


        } catch (\GuzzleHttp\Exception\TransferException $e) {
            return $e->getMessage();
        }
    }

    private function getHeaders()
    {
        return $this->goutteClient->getResponse()->getHeaders();
    }

}