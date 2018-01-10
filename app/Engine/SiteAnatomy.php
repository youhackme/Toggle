<?php

namespace App\Engine;

use App;
use App\Engine\Bot\BotInterface;
use App\Engine\Bot\Driver\BrowserSimulator;
use App\Engine\Bot\Driver\PhantomJS;
use App\Http\Requests\ScanTechnologiesRequest;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\DomCrawler\Crawler;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 10:52.
 */
class SiteAnatomy
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    public $crawler;
    public $styles;
    public $scripts;
    public $metas;
    public $headers;
    public $cookies;
    public $comments;
    public $status;
    public $css;
    public $innerlinks;
    public $html;
    public $errors = [];
    public $url;
    public $originalUrl;
    public $host;
    public $environment = null;
    public $scanMode = 'online';
    public $request;


    /**
     * SiteAnatomy constructor.
     *
     * @param ScanTechnologiesRequest $request
     */
    public function __construct(ScanTechnologiesRequest $request)
    {
        $this->originalUrl = $request->getUrl();

        if (is_null($request->getHtml())) {
            $this->crawl($request);
        } else {
            $this->scanMode = 'offline';

            // Browser simulation
            $this->simulateCrawl($request);
        }

    }

    /**
     * Crawl a url
     *
     * @param $request
     *
     * @return $this
     */
    public function crawl(ScanTechnologiesRequest $request)
    {
        $url = $request->getUrl();

        if (Redis::EXISTS('site:' . $url)) {


            $datas = json_decode(Redis::get('site:' . $url), true);


            foreach ($datas as $key => $value) {

                $this->$key = $value;
            }


            return $this;
        }


        try {
            $bot = new \App\Engine\Bot\Bot(new PhantomJS());

            $data = $bot->crawl($request);

            $this->result($data);


        } catch (\Exception $e) {
            Bugsnag::notifyException($e);
            $this->errors[] = $e;
        }
    }


    /**
     * Get the result from the underlying bot.
     *
     * @param BotInterface $data
     *
     * @return $this
     */
    private function result(BotInterface $data)
    {

        if ( ! ($this->errors())) {

            $this->html = $data->html();

            $this->url         = $this->originalUrl;
            $this->headers     = $data->headers();
            $this->cookies     = $data->cookies();
            $this->environment = $data->environment();
            $this->status      = $data->status();
            $this->host        = $data->host();

            $this->crawler  = new Crawler($this->html);
            $this->styles   = $this->getStyleSheets();
            $this->scripts  = $this->getScripts();
            $this->metas    = $this->metatags();
            $this->comments = $this->getHtmlComments();
            $this->css      = [
                'classes' => $this->getCssClasses(),
                'ids'     => $this->getCssIds(),
            ];


            if ($this->scanMode = 'offline') {
                Redis::set('site:' . $this->originalUrl, json_encode($this));
                Redis::expire('site:' . $this->originalUrl, 86400);

            } else {
                Redis::set('site:' . $this->originalUrl, json_encode($this));
                Redis::expire('site:' . $this->originalUrl, 86400);
            }


            return $this;

        }
    }

    /**
     * Read any errors found.
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * List CSS Sheets.
     *
     * @return array
     */
    private function getStyleSheets()
    {
        $blacklistedDomains = ['googleapis.com'];
        $styleSheets        = [];
        $this->crawler->filterXpath('//link[@rel="stylesheet"]')
                      ->each(function (Crawler $styleSheet) use (&$styleSheets, $blacklistedDomains) {
                          $link = $styleSheet->attr('href');
                          if ( ! str_contains($link, $blacklistedDomains)) {
                              $styleSheets[] = $styleSheet->attr('href');
                          }
                      });

        return array_values(array_unique($styleSheets));
    }

    /**
     * List JS scripts.
     *
     * @return array
     */
    private function getScripts()
    {
        $scripts = [];
        $this->crawler->filterXpath('//script')
                      ->each(function (Crawler $script) use (&$scripts) {
                          if ( ! is_null($script->attr('src'))) {
                              $scripts[] = $script->attr('src');
                          }
                      });

        return array_unique($scripts);
    }

    /**
     * Get meta tags.
     *
     * @return array
     */
    private function metatags()
    {
        $tags = [];
        $this->crawler->filterXpath('//meta[@name="generator"]')
                      ->each(function (Crawler $metaTags) use (&$tags) {
                          $tags['generator'][] = $metaTags->attr('content');
                      });

        return $tags;
    }

    /**
     * Parse HTML Comments.
     *
     * @return array
     */
    private function getHtmlComments()
    {
        if (preg_match_all('/<!-- ([\\s\\S])*?-->/uim', $this->html, $comments)) {
            return $comments[0];
        }
    }

    /**
     * Extract CSS Class names.
     *
     * @return array
     */
    private function getCssClasses()
    {
        $cssClasses = [];
        $this->crawler->filterXpath('//*[@class]')
                      ->each(function (Crawler $cssClass) use (&$cssClasses) {
                          $classes      = trim($cssClass->attr('class'));
                          $classes      = explode(' ', $classes);
                          $cssClasses[] = $classes;
                      });

        $uniqueCssClasses = array_unique(array_flatten($cssClasses));

        $finalCssClasses = [];
        foreach ($uniqueCssClasses as $uniqueCssClass) {
            if (strlen($uniqueCssClass) > 5) {
                $finalCssClasses[] = $uniqueCssClass;
            }
        }

        return $finalCssClasses;
    }

    /**
     * Extract CSS Ids.
     *
     * @return array
     */
    private function getCssIds()
    {
        $cssIds = [];
        $this->crawler->filterXpath('//*[@id]')
                      ->each(function (Crawler $cssId) use (&$cssIds) {
                          $cssIds[] = trim($cssId->attr('id'));
                      });

        $uniqueCssIds = array_unique(array_flatten($cssIds));

        $finalCssIds = [];
        foreach ($uniqueCssIds as $uniqueCssId) {
            if (strlen($uniqueCssId) > 5) {
                $finalCssIds[] = $uniqueCssId;
            }
        }

        return $finalCssIds;
    }

    /**
     * Simulate site crawling
     *
     * @param ScanTechnologiesRequest $request
     */
    public function simulateCrawl(ScanTechnologiesRequest $request)
    {
        try {

            $bot = new \App\Engine\Bot\Bot(new BrowserSimulator());

            $data = $bot->crawl($request);
            $this->result($data);

        } catch (\Exception $e) {
            Bugsnag::notifyException($e);
            $this->errors[] = $e->getMessage();
        }
    }


}
