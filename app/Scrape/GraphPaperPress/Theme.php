<?php

namespace App\Scrape\GraphPaperPress;

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

        $pageToCrawl = 'https://graphpaperpress.com/themes/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'graphpaperpress.com';


        $crawler->filter('div.three-col div.theme')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name'] = trim($themelist->filter('h2.entry-title')->text());

                    $theme['downloadlink'] = $themelist->filter('h2.entry-title a')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('a.screenshot img')
                                                        ->attr('data-src');

                    $price = $themelist->filter('div.corner-ribbon')
                                       ->text();

                    $theme['type'] = 'premium';

                    if ($price == 'Free') {
                        $theme['type'] = 'free';
                    }


                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );

                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('h3.entry-description')
                            ->text());


                    } catch (\Exception $e) {
                        echo 'Could not scrape theme full page' . $e->getMessage() . br();
                    }

                    $theme['previewlink'] = 'https://demo.graphpaperpress.com/' . $theme['uniqueidentifier'] . '/';

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
