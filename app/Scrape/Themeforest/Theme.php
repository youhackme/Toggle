<?php

namespace App\Scrape\Themeforest;

use App\Repositories\Theme\ThemeRepository;
use App\Scrape\ScraperInterface;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */
class Theme implements ScraperInterface
{


    /**
     * Store theme meta data
     * @var array
     */
    private $crawler;

    /**
     * Goutte Client
     * @var
     */
    private $goutteClient;


    /**
     * An instance of Theme Repository
     * @var ThemeRepository
     */
    protected $theme;


    public function __construct(ThemeRepository $theme)
    {
        $this->theme        = $theme;
        $this->goutteClient = \App::make('goutte');
    }


    public function scrape($page = 1)
    {

        $pageToCrawl = 'https://themeforest.net/category/wordpress?page=' . $page . '&utf8=%E2%9C%93&referrer=search&view=list&sort=sales';
        echo "Scraping page: $pageToCrawl";
        echo br();


        $this->crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );


        $theme = [];

        $theme['provider'] = 'themeforest.net';
        $theme['type']     = 'premium';


        $this->crawler->filter('li.js-google-analytics__list-event-container')->each(function ($themelist) use (
            &
            $theme
        ) {

            // The theme Unique id
            $theme['uniqueidentifier'] = $themelist->attr('data-item-id');

            // The theme name
            $themelist->filter('h3')->each(function ($themeTitle) use (&$theme) {
                $theme['name'] = $themeTitle->text();

            });


            // The theme preview  screenshot
            $themelist->filter('img.preload')->each(function ($themeImage) use (&$theme) {
                $theme['screenshotUrl'] = $themeImage->attr('data-preview-url');
            });


            // Click on each theme name and go to their theme page details
            if ( ! empty(trim($theme['name']))) {

                try {
                    $link                 = $this->crawler->selectLink(trim($theme['name']))->link();
                    $crawlerThemefullPage = $this->goutteClient->click($link);


                    // Get the Preview URL
                    $crawlerThemefullPage->filter('a.live-preview')->each(function ($themePreviewlink) use (
                        &
                        $theme
                    ) {
                        $theme['downloadLink'] = $themePreviewlink->attr('href');
                    });


                    // Get the theme description
                    $crawlerThemefullPage->filter('div.item-description')->each(function ($themeDescription) use (
                        &$theme
                    ) {
                        $theme['description'] = $themeDescription->text();
                    });

                    // Click on the preview link
                    $previewlink             = $crawlerThemefullPage->selectLink('Live Preview')->link();
                    $crawlerThemePreviewLink = $this->goutteClient->click($previewlink);


                    // Get the theme url hosted by the author
                    $crawlerThemePreviewLink->filter('div.preview__action--close a')->each(function (
                        $themeDescription
                    ) use (
                        &$theme
                    ) {
                        $theme['PreviewLink'] = $themeDescription->attr('href');


                    });


                    $this->theme->save($theme);


                } catch (\InvalidArgumentException $e) {
                    echo "Well, it sucks. Cannot scrape: " . json_encode($theme['id']);
                }
            } else {
                echo "No data for" . $theme['id'];
            }

        });


    }


    public function extractThemeAlias()
    {

        $this->theme->chunk(10, function ($themes) {
            foreach ($themes as $theme) {

                echo 'Author url: ' . $theme->previewlink;
                echo br();

                $this->crawler = $this->goutteClient->request(
                    'GET',
                    $theme->previewlink
                );

                // Algo:
                // 1. Do you have an iframe?
                // 2. if yes, remove iframe



                if ( ! empty($this->crawler->filter('iframe')->count())) {

                    // Get the theme url hosted by the author
                    $this->crawler->filter('iframe')->each(function ($iframe) use ($theme) {
                        $iframeBlacklist = ['vimeo', 'youtube', 'video'];
                        if ( containsInList($iframe->attr('src'),$iframeBlacklist)) {
                            $iframeUrl = $iframe->attr('src');
                            echo "$iframeUrl is fake! The is @ $theme->previewlink";
                        }

                        echo br();
                    });


                    //   echo $this->crawler->filter('iframe')->attr('src');

                    echo "<hr/>";
                } else {
                    echo "<p style='color:red;'>No iframe</p>";
                    echo br();
                    echo "<hr/>";
                }


                //  echo $this->goutteClient->getResponse()->getContent();


            }
        });

    }


}