<?php

namespace App\Scrape\Themify;

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

        $pageToCrawl = 'https://themify.me/themes';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'themify.me';
        $theme['type']     = 'premium';


        $crawler->filter('li.theme-post')
                ->each(function (Crawler $themelist) use (&$theme) {

                    if ($themelist->filter('div.theme-title h3 a')->count()) {


                        $theme['name']         = $themelist->filter('div.theme-title h3 a')->text();
                        $theme['downloadlink'] = $themelist->filter('div.theme-title h3 a')->attr('href');

                        $uniqueidentifier = $themelist->filter('div.theme-title h3 a')->attr('href');
                        $uniqueidentifier = explode('/', $uniqueidentifier);

                        $theme['uniqueidentifier'] = $uniqueidentifier['4'];

                        $theme['screenshoturl'] = $themelist->filter('figure.theme-image img')->attr('src');
                        $theme['description']   = trim($themelist
                            ->filter('div.theme-excerpt')
                            ->text());
                        $theme['previewlink']   = 'https://themify.me/demo/themes/' . $theme['uniqueidentifier'] . '/';
                        if ($this->theme->save($theme)) {
                            echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                        } else {
                            echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
                        }
                        echo br();

                    }


                    unset($theme);

                });


    }
}
