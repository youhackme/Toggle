<?php

namespace App\Engine;

use App;
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
    public $host;
    public $environment = null;

    /**
     * SiteAnatomy constructor.
     *
     * @param $site
     */
    public function __construct($site)
    {
        $url = str_contains($site, ['http://', 'https://']) ? $site : 'http://' . $site;

        $this->crawl($url);
    }

    public function crawl($url)
    {

        if (Redis::EXISTS('site:' . $url)) {


            $datas = json_decode(Redis::get('site:' . $url), true);


            foreach ($datas as $key => $value) {

                $this->$key = $value;
            }


            return $this;
        }


        try {
            $bot = new \App\Engine\Bot\Bot(new \App\Engine\Bot\PhantomJS());

            $data = $bot->crawl($url);

            $this->result($data);


        } catch (\Exception $e) {

            $this->errors[] = $e->getMessage();
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


            $this->url         = $data->url();
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


            Redis::set('site:' . $this->url, json_encode($this));
            Redis::expire('site:' . $this->url, 3600);

            return $this;

        }
    }


}
