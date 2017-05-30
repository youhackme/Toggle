<?php

namespace App\Scrape\MyThemeShop;

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

        $pageToCrawl = 'https://mythemeshop.com/themes/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'mythemeshop.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.post-theme')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name']         = $themelist->filter('h2.theme-title')->text();
                    $theme['downloadlink'] = $themelist->filter('a.theme-thumb')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                    $theme['screenshoturl'] = $themelist->attr('data-three-columns-image');


                    // Go to full theme page to get description
                    try {

                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $theme['downloadlink']
                        );

                        $theme['description'] = trim($crawlerThemefullPage
                            ->filter('div.single_excerpt')
                            ->text());

                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }


                    $theme['previewlink'] = 'https://demo.mythemeshop.com/' . $theme['uniqueidentifier'] . '/';


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
