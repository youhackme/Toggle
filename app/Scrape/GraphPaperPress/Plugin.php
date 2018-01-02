<?php

namespace App\Scrape\GraphPaperPress;

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

        $pageToCrawl = 'https://graphpaperpress.com/plugins/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'graphpaperpress.com';
        $plugin['type']     = 'premium';

        $crawler->filter('article.two-col')
                ->each(function (Crawler $pluginlist) use (&$plugin) {


                    $plugin['name'] = trim($pluginlist->filter('h2.entry-title')->text());

                    $plugin['downloadlink'] = $pluginlist->filter('h2.entry-title a')->attr('href');


                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['4'];

                    $plugin['screenshoturl'] = $pluginlist->filter('img')
                                                          ->attr('data-src');

                    $plugin['type'] = 'premium';


                    $plugin['description'] = trim($pluginlist
                        ->filter('div.entry-content p')
                        ->text());


                    $plugin['previewlink'] = 'https://demo.graphpaperpress.com/' . $plugin['uniqueidentifier'] . '/';


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
