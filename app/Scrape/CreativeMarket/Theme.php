<?php

namespace App\Scrape\CreativeMarket;

use App\Scrape\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Theme\ThemeRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Theme implements ScraperInterface
{
    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * Theme constructor.
     *
     * @param ThemeRepository $theme
     */
    public function __construct(ThemeRepository $theme)
    {
        $this->theme        = $theme;
        $this->goutteClient = \App::make('goutte');
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {
        // Categories: blog, business,commerce,landing,magazine,minimal,non-profit,photography,portfolio,wedding
        $pageToCrawl = 'https://creativemarket.com/themes/wordpress/portfolio/' . $page;

        echo "Page: $pageToCrawl" . br();


        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'creativemarket.com';
        $theme['type']     = 'premium';

        // dd($crawler->html());
        $crawler->filter('ul.products li')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name']             = $themelist->attr('data-title');
                    $theme['uniqueidentifier'] = $themelist->attr('data-id');
                    $theme['screenshoturl']    = $themelist->attr('data-media');
                    $theme['downloadlink']     = $themelist->attr('data-canonical');

                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );
                        sleep(5);
                        $theme['previewlink'] = $crawlerThemefullPage
                            ->filter('a#btn-live-preview')
                            ->attr('href');


                        $theme['description'] = $crawlerThemefullPage
                            ->filter('section.product-description')
                            ->text();


                        if ($this->theme->save($theme)) {
                            echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                        } else {
                            echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
                        }
                        echo br();
                    } catch (\Exception $e) {
                        // Remove previous scrapped data before saving
                        unset($theme['description'], $theme['previewlink']);
                        echo 'No preview url for theme:.' . json_encode($theme['name']) . br();
                        echo $e->getMessage() . br();
                        // Save theme even if we have partial data.
                        $this->theme->save($theme);
                        unset($theme);
                    }


                    unset($theme);

                });


    }
}
