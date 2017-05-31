<?php

namespace App\Scrape\ThemeTrust;

use App\Scrape\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Plugin\PluginRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Plugin implements ScraperInterface
{
    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

    /**
     * An instance of Plugin Repository.
     *
     * @var PluginRepository
     */
    protected $plugin;

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

        $pageToCrawl = 'https://themetrust.com/plugin/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'themetrust.com';
        $plugin['type']     = 'free';


        $crawler->filter('div.theme-feature-row')
                ->each(function (Crawler $pluginlist) use (&$plugin) {


                    $plugin['name']         = $pluginlist->filter('div.wpb_wrapper h3')->text();
                    $plugin['downloadlink'] = $pluginlist->filter('div.vc_btn3-inline a')->attr('href');


                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['4'];

                    $plugin['screenshoturl'] = $pluginlist->filter('div.vc_single_image-wrapper img')
                                                          ->attr('src');


                    $plugin['description'] = trim($pluginlist
                        ->filter('div.wpb_wrapper p')
                        ->text());


                    $plugin['previewlink'] = str_replace(
                        'https://themetrust.com/themes/',
                        'http://demos.themetrust.com/',
                        $plugin['downloadlink']);


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
