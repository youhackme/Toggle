<?php

namespace App\Scrape\Tesla;

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

        $pageToCrawl = 'http://teslathemes.com/wordpress-themes/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();


        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'teslathemes.com';
        $theme['type']     = 'premium';


        $crawler->filter('ul.tt-themes-list li.tt-themes-item')
                ->each(function (Crawler $themelist) use (&$theme) {

                    // Skip middle banner
                    if ($themelist->filter('h2.theme-title')->count()) {
                        $name    = $themelist->filter('h2.theme-title')->text();
                        $tagline = $themelist->filter('h4.theme-tagline')->text();

                        $theme['name'] = "$name - $tagline";

                        $theme['uniqueidentifier'] = $name;
                        $theme['screenshoturl']    = $themelist->filter('div.preview-desktop img')->attr('src');
                        $theme['downloadlink']     = $themelist->filter('div.theme-buttons a.btn-gradient')
                                                               ->attr('href');


                        $themeSlug            = explode('/', $theme['downloadlink']);
                        $themeSlug            = $themeSlug['4'];
                        $theme['previewlink'] = 'http://demo.teslathemes.com/' . $themeSlug . '/';


                        try {
                            // Navigate to the theme full page
                            $crawlerThemefullPage = $this->goutteClient->request(
                                'GET',
                                $theme['downloadlink']
                            );


                            $theme['description'] = trim($crawlerThemefullPage
                                ->filter('div.theme-short-description')
                                ->text());


                            if ($this->theme->save($theme)) {
                                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                            } else {
                                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
                            }
                            echo br();
                        } catch (\Exception $e) {
                            // Remove previous scrapped data before saving
                            unset($theme['description']);
                            echo 'No preview url for theme:.' . json_encode($theme['name']) . br();
                            echo $e->getMessage() . br();
                            // Save theme even if we have partial data.
                            $this->theme->save($theme);
                            unset($theme);
                        }
                    }


                    unset($theme);

                });


    }
}
