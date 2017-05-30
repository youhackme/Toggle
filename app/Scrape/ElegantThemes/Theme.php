<?php

namespace App\Scrape\ElegantThemes;

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
        if ($page == 1) {
            // The page 1 is not scrappable - not same format as other page
            $page = 2;
        }

        $pageToCrawl = 'https://www.elegantthemes.com/gallery/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'elegantthemes.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.et_box_1_3')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name']         = $themelist->filter('h2')->text();
                    $theme['downloadlink'] = 'https://www.elegantthemes.com' . $themelist
                            ->filter('div.theme-img a')
                            ->attr('href');


                    $uniqueidentifier = $theme['downloadlink'];
                    $uniqueidentifier = explode('/', $uniqueidentifier);


                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('div.theme-img img')->attr('src');


                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );

                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('p#theme_quote')
                            ->text());


                        $demoUrl = $crawlerThemefullPage
                            ->filter('div#main-actions a#view')
                            ->attr('href');

                        $demoUrl = str_replace('https://www.elegantthemes.com/demo/?theme=',
                            'http://www.elegantthemes.com/preview/', $demoUrl);


                        $theme['previewlink'] = $demoUrl . '/';


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
