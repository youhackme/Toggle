<?php

namespace App\Scrape\CreativeMarket;

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
     * Scrape plugin.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {
        $pageToCrawl = 'https://creativemarket.com/themes/wordpress/plugins/' . $page;

        echo "Page: $pageToCrawl" . br();


        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'creativemarket.com';
        $plugin['type']     = 'premium';


        $crawler->filter('ul.products li')
                ->each(function (Crawler $pluginlist) use (&$plugin) {


                    $plugin['name']             = $pluginlist->attr('data-title');
                    $plugin['uniqueidentifier'] = $pluginlist->attr('data-id');
                    $plugin['screenshoturl']    = $pluginlist->attr('data-media');
                    $plugin['downloadlink']     = $pluginlist->attr('data-canonical');

                    try {
                        // Navigate to the plugin full page
                        $crawlerPluginfullPage = $this->goutteClient->request(
                            'GET',
                            $plugin['downloadlink']
                        );
                        sleep(2);
                        $plugin['previewlink'] = $crawlerPluginfullPage
                            ->filter('a#btn-live-preview')
                            ->attr('href');


                        $plugin['description'] = $crawlerPluginfullPage
                            ->filter('section.product-description')
                            ->text();


                        if ($this->plugin->save($plugin)) {
                            echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' saved successfully';
                        } else {
                            echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' already exists in database.';
                        }
                        echo br();
                    } catch (\Exception $e) {
                        // Remove previous scrapped data before saving
                        unset($plugin['description'], $plugin['previewlink']);
                        echo 'No preview url for plugin:.' . json_encode($plugin['name']) . br();
                        echo $e->getMessage() . br();
                        // Save plugin even if we have partial data.
                        $this->plugin->save($plugin);

                        unset($plugin);
                    }


                    unset($plugin);

                });


    }
}
