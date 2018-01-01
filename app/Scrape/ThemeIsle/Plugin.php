<?php

namespace App\Scrape\ThemeIsle;

use App\Repositories\Plugin\PluginRepository;
use App\Scrape\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Plugin implements ScraperInterface
{
    /**
     * An instance of Plugin Repository.
     *
     * @var PluginRepository
     */
    protected $plugin;
    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

    /**
     * Plugin constructor.
     *
     * @param PluginRepository $plugin
     */
    public function __construct(PluginRepository $plugin)
    {
        $this->plugin       = $plugin;
        $this->goutteClient = \App::make('goutte');
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {

        $pageToCrawl = 'https://themeisle.com/wordpress-plugins/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'themeisle.com';


        $crawler->filter('div.theme')
                ->each(function (Crawler $pluginlist) use (&$plugin) {

                    $plugin['type'] = 'premium';
                    $plugin['name'] = $pluginlist->filter('h3.theme-link a')->text();

                    $plugin['downloadlink'] = $pluginlist->filter('div.theme-pic a')->attr('href');

                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['4'];

                    $plugin['screenshoturl'] = $pluginlist->filter('div.theme-pic img')
                                                          ->attr('src');


                    $plugin['description'] = trim($pluginlist
                        ->filter('div.theme-type')
                        ->text());


                    $plugin['previewlink'] = str_replace(
                        'https://themeisle.com/themes/',
                        'https://demo.themeisle.com/',
                        $plugin['downloadlink']);


                    $price = $pluginlist
                        ->filter('.edd_price')
                        ->text();
                    if ($price == 'Free') {
                        $plugin['type'] = 'free';
                    }


                    if ($this->plugin->save($plugin)) {
                        echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' saved successfully';
                    } else {
                        echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' already exists in database.';
                    }
                    echo br();

                    unset($plugin);

                });


    }
}
