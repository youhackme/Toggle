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

    /**
     * Scrape theme
     *
     * @param int $page
     */
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
            $theme['name'] = $themelist->filter('h3')->text();


            // The theme preview  screenshot
            $theme['screenshoturl'] = $themelist->filter('img.preload')->attr('data-preview-url');


            // Click on each theme name and go to their theme page details
            if ( ! empty(trim($theme['name']))) {


                try {


                    $themeFullPageUrl = $themelist->filter('h3 a')->attr('href');
                    // Navigate to the theme full page
                    $crawlerThemefullPage = $this->goutteClient->request(
                        'GET',
                        'https://' . $theme['provider'] . $themeFullPageUrl
                    );


                    // Then, click on the Preview URL
                    $theme['downloadlink'] = $crawlerThemefullPage
                        ->filter('a.live-preview')
                        ->attr('href');


                    //to get the Theme description
                    $theme['description'] = $crawlerThemefullPage
                        ->filter('div.item-description')
                        ->text();

                    // Get the preview url of the theme
                    $livePreviewLink = $crawlerThemefullPage
                        ->filter('a.live-preview')
                        ->attr('href');

                    //Click on the preview link button on the theme full page
                    $crawlerThemepreviewlink = $this->goutteClient->request(
                        'GET',
                        $livePreviewLink
                    );


                    // Get the initial theme url hosted by the author
                    // Then attempt to get the deeplink url
                    $theme['previewlink'] = $this->getRealThemeUrl($crawlerThemepreviewlink
                        ->filter('div.preview__action--close a')
                        ->attr('href'));


                    $this->theme->save($theme);


                } catch (\Exception $e) {
                    echo "No preview url for theme:." . json_encode($theme['uniqueidentifier']) . br();
                    echo $e->getMessage() . br();
                    // Save theme even if we have partial data.
                    $this->theme->save($theme);
                }
            } else {
                echo "No data for" . $theme['uniqueidentifier'];
            }
            unset($theme);

        });


    }

    /**
     * Extract theme Alias based on the theme Url
     */
    public function extractThemeAlias()
    {


        $this->theme->chunk(10, function ($themes) {
            foreach ($themes as $theme) {
                $site = $theme->previewlink;
                echo 'Author url: ' . $site;
                echo br();
                $siteAnatomy = (new \App\Engine\SiteAnatomy($site));
                $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

                if ($application->isWordPress()) {
                    echo $application->details();
                } else {
                    echo "Sadly, you are not using WordPress";
                }
                echo br();

            }
        });

    }


    /**
     * Attempt to detect the theme demo URL (The one without iframe)
     *
     * @param $previewLink
     *
     * @return mixed
     */
    private function getRealThemeUrl($previewLink)
    {

        try {
            //Crawl the theme preview url
            $crawlerAuthorUrl = $this->goutteClient->request(
                'GET',
                $previewLink
            );
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            echo $e->getMessage();

            return $previewLink;
        }
        // Do you have at least one iframe?
        if ( ! empty($crawlerAuthorUrl->filter('iframe')->count())) {

            // Get the theme url hosted by the author
            $crawlerAuthorUrl->filter('iframe')->each(function ($iframe) use (&$previewLink) {
                //Extract iframes only if you do not contain any of these words
                $iframeBlacklist = [
                    'vimeo',
                    'youtube',
                    'video',
                    'googletagmanager',
                    'google.com',
                    'data:image',
                    'facebook',
                    'soundcloud',
                    'mixcloud',
                ];
                $iframeUrl       = $iframe->attr('src');
                if ( ! containsInList($iframeUrl, $iframeBlacklist)) {
                    $previewLink = $iframeUrl;
                }

            });

        }

        return $previewLink;

    }


}