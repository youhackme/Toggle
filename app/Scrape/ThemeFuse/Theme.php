<?php

namespace App\Scrape\ThemeFuse;

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

        $pageToCrawl = 'https://themefuse.com/wp-themes-shop/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'themefuse.com';
        $theme['type']     = 'premium';


        $crawler->filter('li.theme-item')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name'] = explode(PHP_EOL, $themelist->filter('div.theme-title')->text());
                    $theme['name'] = $theme['name']['0'];

                    $theme['downloadlink'] = $themelist->filter('div.theme-image a')->attr('href');


                    $uniqueidentifier = $themelist->filter('div.theme-image a')->attr('href');
                    $uniqueidentifier = explode('/', $uniqueidentifier);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->filter('div.theme-image img')
                                                        ->attr('src');


                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );

                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('div.theme-desc p')
                            ->text());

                        $demoUrlWithIframe = $crawlerThemefullPage
                            ->filter('a.btn-demo')
                            ->attr('href');


                    } catch (\Exception $e) {
                        echo 'Could not scrape theme full page' . $e->getMessage() . br();
                    }


                    try {
                        // Navigate to the theme full page
                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $demoUrlWithIframe
                        );

                        $theme['previewlink'] = trim($crawlerThemefullPage
                            ->filter('iframe.demo-iframe-link')
                            ->attr('src'));


                    } catch (\Exception $e) {
                        echo 'Could not get the real demo url' . $e->getMessage() . br();
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
