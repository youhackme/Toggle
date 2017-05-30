<?php

namespace App\Scrape\IThemes;

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

        $pageToCrawl = 'https://ithemes.com/find/themes/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'ithemes.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.theme-item')
                ->each(function (Crawler $themelist) use (&$theme) {

                    $theme['name']         = $themelist->filter('h4.theme-title')->text();
                    $theme['downloadlink'] = $themelist->filter('h4.theme-title a')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('.featured-image img')->attr('src');
                    $theme['previewlink']   = $themelist->filter('a.theme-demo')->attr('href');

                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );

                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('div#theme-info p')
                            ->text());


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

                });
    }
}
