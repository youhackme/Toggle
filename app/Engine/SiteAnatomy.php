<?php

namespace App\Engine;

use App;
use App\Engine\Bot\Driver\BrowserSimulator;
use App\Engine\Bot\Driver\PhantomJS;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\DomCrawler\Crawler;

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


    /**
     * SiteAnatomy constructor.
     *
     * @param      $site
     * @param null $requestInfo
     */
    public function __construct($site, $requestInfo = null)
    {
        $url = str_contains($site, ['http://', 'https://']) ? $site : 'http://' . $site;

        if (is_null($requestInfo)) {
            $this->crawl($url);
        } else {
            $this->scanMode = 'offline';
            // Browser simulation
            $this->simulateCrawl($requestInfo);
        }

    }

    /**
     * Simulate site crawling
     *
     * @param $requestInfo
     */
    public function simulateCrawl($requestInfo)
    {

        try {

            $bot = new \App\Engine\Bot\Bot(new BrowserSimulator());

            $data = $bot->crawl($requestInfo);

            $this->result($data);

        } catch (\Exception $e) {

            $this->errors[] = $e->getMessage();
        }
    }

    /**
     * Crawl a url
     *
     * @param $url
     *
     * @return $this
     */
    public function crawl($url)
    {

        $this->originalUrl = $url;

        if (Redis::EXISTS('site:' . $url)) {


            $datas = json_decode(Redis::get('site:' . $url), true);


            foreach ($datas as $key => $value) {

                $this->$key = $value;
            }


            return $this;
        }


        try {
            $bot = new \App\Engine\Bot\Bot(new PhantomJS());

            $data = $bot->crawl($url);

            $this->result($data);


        } catch (\Exception $e) {

            $this->errors[] = $e;
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
     * Get the result.
     *
     * @param $data
     *
     * @return $this
     */
    private function result($data)
    {

        if ( ! ($this->errors())) {

            $this->html = $data->html();


            $this->url         = $this->originalUrl;
            $this->headers     = $data->headers();
            $this->cookies     = $data->cookies();
            $this->environment = $data->environment();
            $this->status      = $data->status();
            $this->host        = $data->host();

            $this->crawler = new Crawler($this->html);
            $this->styles  = $this->getStyleSheets();
            $this->scripts = $this->getScripts();
            $this->metas   = $this->metatags();
            // $this->headers = $this->getHeaders();
            // $this->cookies  = $this->getCookies();
            $this->comments = $this->getHtmlComments();
            // $this->status   = $this->getStatus();
            $this->css = [
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


}
