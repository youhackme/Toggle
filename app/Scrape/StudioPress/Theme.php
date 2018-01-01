<?php

namespace App\Scrape\StudioPress;

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

        $pageToCrawl = 'https://my.studiopress.com/themes/';

        echo "Page: $pageToCrawl" . br();


        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'studiopress.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.theme-wrap')
                ->each(function (Crawler $themelist) use (&$theme) {


                    // Skip middle banner
                    if ($themelist->filter('h2.entry-title')->count()) {


                        $theme['name']         = $themelist->filter('h2.entry-title')->text();
                        $theme['downloadlink'] = $themelist->filter('div.theme-wrap-inner a.info')
                                                           ->attr('href');

                        $uniqueidentifier          = explode('/', $theme['downloadlink']);
                        $theme['uniqueidentifier'] = $uniqueidentifier['4'];


                        try {
                            // Navigate to the theme full page
                            $crawlerThemefullPage = $this->goutteClient->request(
                                'GET',
                                $theme['downloadlink']
                            );

                            $theme['previewlink'] = $crawlerThemefullPage
                                ->filter('div.full-screen iframe')
                                ->attr('src');


                            $theme['description'] = $crawlerThemefullPage
                                ->filter('div.theme-info p')
                                ->text();

                            $theme['screenshoturl'] = $crawlerThemefullPage
                                ->filter('div.laptop-screen img')
                                ->attr('src');


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

                    }
                    unset($theme);

                });


    }
}
