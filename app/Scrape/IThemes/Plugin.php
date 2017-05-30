<?php

namespace App\Scrape\IThemes;

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

        $pageToCrawl = 'https://ithemes.com/find/plugins/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'ithemes.com';
        $plugin['type']     = 'premium';


        $crawler->filter('a.plugin-item')
                ->each(function (Crawler $pluginlist) use (&$plugin) {

                    $plugin['name']         = $pluginlist->filter('div.plugin-title')->text();
                    $plugin['downloadlink'] = $pluginlist->attr('href');
                    
                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['4'];

                    $plugin['screenshoturl'] = $pluginlist->filter('div.featured-image img')->attr('src');
                    $plugin['previewlink']   = $plugin['downloadlink'];

                    $plugin['description'] = trim($pluginlist
                        ->filter('div.plugin-excerpt')
                        ->text());

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
