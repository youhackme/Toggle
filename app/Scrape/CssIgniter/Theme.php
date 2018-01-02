<?php

namespace App\Scrape\CssIgniter;

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

        $pageToCrawl = 'https://www.cssigniter.com/ignite/themes/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'cssigniter.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.item')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name'] = $themelist->filter('h2.item-title')->text();


                    $theme['downloadlink'] = $themelist->filter('h2.item-title a')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['5'];

                    $theme['screenshoturl'] = $themelist->filter('figure.item-thumb img')
                                                        ->attr('src');


                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );


                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('div.page-hero p')
                            ->text());


                    } catch (\Exception $e) {
                        echo 'Could not scrape theme full page' . $e->getMessage() . br();
                    }


                    $theme['previewlink'] = str_replace(
                        'https://www.cssigniter.com/ignite/themes/',
                        'https://www.cssigniter.com/preview/',
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
