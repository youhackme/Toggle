<?php

namespace App\Scrape\Shape5;

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
        if ($page == '1') {
            $pageToCrawl = 'https://www.shape5.com/wordpress/themes/';
        } else {
            $pageToCrawl = 'https://www.shape5.com/wordpress/themes/page_' . $page . '.html';
        }


        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $theme             = [];
        $theme['provider'] = 'shape5.com';
        $theme['type']     = 'premium';


        $crawler->filter('div.s5_contentlistoutter')
                ->each(function (Crawler $themelist) use (&$theme) {


                    $theme['name'] = trim($themelist->filter('a.contentpagetitle')->text());

                    $theme['downloadlink'] = $themelist->filter('a.contentpagetitle')->attr('href');


                    $uniqueidentifier = explode('/', $theme['downloadlink']);

                    $theme['uniqueidentifier'] = $uniqueidentifier['5'];

                    $theme['screenshoturl'] = $themelist->filter('div.theme_image_wrap_inner  img')
                                                        ->attr('src');

                    $previewHtml = trim($themelist
                        ->filter('.theme_image_buttons')
                        ->html());

                    $previewlink = '';
                    if (preg_match('/window.open[(][\'](\S+)[\'][)]["][>]/', $previewHtml, $match)) {
                        $previewlink = $match[1];
                    }

                    $theme['previewlink'] = str_replace(
                        'http://www.shape5.com/demo/index.php?',
                        'http://www.shape5.com/demo/',
                        $previewlink
                    );


                    if ($this->theme->save($theme)) {
                        echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
                    } else {
                        echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database . ';
                    }
                    echo br();


                    unset($theme);

                });


    }
}
