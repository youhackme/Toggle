<?php

namespace App\Scrape\ThemeTrust;

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

        $pageToCrawl = 'https://themetrust.com/themes/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'themetrust.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.theme-feature-row')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name']         = $themelist->filter('div.wpb_wrapper h3')->text();
                    $theme['downloadlink'] = $themelist->filter('div.vc_btn3-inline a')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('div.vc_single_image-wrapper img')
                                                        ->attr('src');


                    $theme['description'] = trim($themelist
                        ->filter('div.wpb_wrapper p')
                        ->text());


                    $theme['previewlink'] = str_replace(
                        'https://themetrust.com/themes/',
                        'http://demos.themetrust.com/',
                        $theme['downloadlink']);


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
