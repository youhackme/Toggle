<?php

namespace App\Scrape\CssIgniter;

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

        $pageToCrawl = 'https://www.cssigniter.com/ignite/plugins/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'cssigniter.com';
        $plugin['type']     = 'premium';


        $crawler->filter('div.item')
                ->each(function (Crawler $pluginlist) use (&$plugin) {


                    $plugin['name'] = $pluginlist->filter('h2.item-title')->text();


                    $plugin['downloadlink'] = $pluginlist->filter('h2.item-title a')->attr('href');


                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['5'];

                    $plugin['screenshoturl'] = $pluginlist->filter('figure.item-thumb img')
                                                          ->attr('src');


                    try {
                        // Navigate to the theme full page
                        $crawlerPluginfullPage = $this->goutteClient->request(
                            'GET',
                            $plugin['downloadlink']
                        );


                        $plugin['description'] = trim($crawlerPluginfullPage
                            ->filter('div.page-hero p')
                            ->text());


                    } catch (\Exception $e) {
                        echo 'Could not scrape theme full page' . $e->getMessage() . br();
                    }


                    $plugin['previewlink'] = str_replace(
                        'https://www.cssigniter.com/ignite/plugins/',
                        'https://www.cssigniter.com/preview/',
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
