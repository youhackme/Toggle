<?php

namespace App\Scrape\WooThemes;

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

        $pageToCrawl = 'https://woocommerce.com/product-category/themes/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'woocommerce.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.col-full > ul.products li.product')
                ->each(function (Crawler $themelist) use (&$theme) {

                    if ( ! $themelist->filter('li.promo-block')->count()) {
                        try {


                            $theme['name'] = $themelist->filter('span.title')->text();


                            $theme['downloadlink']     = $themelist->filter('a')->attr('href');
                            $uniqueidentifier          = explode('/', $theme['downloadlink']);
                            $theme['uniqueidentifier'] = $uniqueidentifier['4'];
                            $theme['screenshoturl']    = $themelist->filter('img')->attr('src');
                            $theme['description']      = trim($themelist
                                ->filter('span.description')
                                ->text());
                            $theme['previewlink']      = 'http://demo.woothemes.com/' . $theme['uniqueidentifier'] . '/';


                            if ($this->theme->save($theme)) {
                                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                            } else {
                                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
                            }

                        } catch (\Exception $e) {
                            dd($e);
                        }

                        echo br();

                    }

                    unset($theme);

                });


    }
}
