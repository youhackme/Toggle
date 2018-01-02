<?php

namespace App\Scrape\ThemeIsle;

use App\Repositories\Theme\ThemeRepository;
use App\Scrape\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Theme implements ScraperInterface
{
    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;
    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

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

        $pageToCrawl = 'https://themeisle.com/wordpress-themes/all/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'themeisle.com';


        $crawler->filter('div.theme2')
                ->each(function (Crawler $themelist) use (&$theme) {

                    $theme['type'] = 'premium';
                    $theme['name'] = $themelist->filter('h3.theme-link a')->text();

                    $theme['downloadlink'] = $themelist->filter('div.theme-pic a')->attr('href');

                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('div.theme-pic img')
                                                        ->attr('src');


                    $theme['description'] = trim($themelist
                        ->filter('div.theme-type')
                        ->text());


                    $theme['previewlink'] = str_replace(
                        'https://themeisle.com/themes/',
                        'https://demo.themeisle.com/',
                        $theme['downloadlink']);

                    $price = $themelist
                        ->filter('.edd_price')
                        ->text();
                    if ($price == 'Free') {
                        $theme['type'] = 'free';
                    }

                    if ($this->theme->save($theme)) {
                        echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                    } else {
                        echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
                    }
                    echo br();

                    unset($theme);

                });


    }
}
