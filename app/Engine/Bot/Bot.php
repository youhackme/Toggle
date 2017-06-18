<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:39
 */

namespace App\Engine\Bot;


class Bot
{

    /**
     * Our bot may be PhantomJS or Simply curl
     * @var BotInterface
     */
    public $bot;

    /**
     * Bot constructor.
     *
     * @param $bot
     */
    public function __construct(BotInterface $bot)
    {
        $this->bot = $bot;
    }

    public function crawl($url)
    {
        return $this->bot->request($url);
    }

}