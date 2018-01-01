<?php

namespace App\Scrape\Templatic;

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
        $pageToCrawl = 'https://templatic.com/wordpress-themes-store/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'templatic.com';
        $theme['type']     = 'premium';


        $crawler->filter('li.theme-wrap')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name'] = $themelist->filter('figcaption a')->text();


                    $theme['downloadlink'] = $themelist->filter('figcaption a')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('figure img')
                                                        ->attr('src');
                    $theme['previewlink']   = $themelist->filter('a#tmpl_demo_link[target="blank"]')
                                                        ->attr('href');

                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );


                        $theme['description'] = '';
                        if ($crawlerThemefullPage->filter('div.sec-title')->count() != 0) {
                            $theme['description'] = trim($crawlerThemefullPage
                                ->filter('div.sec-title')
                                ->text());
                        }


                    } catch (\Exception $e) {
                        echo 'Could not scrape theme full page' . $e->getMessage() . br();
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
