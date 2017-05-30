<?php

namespace App\Scrape\MyThemeShop;

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

        $pageToCrawl = 'https://mythemeshop.com/plugins/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'mythemeshop.com';
        $plugin['type']     = 'premium';


        $crawler->filter('div.post-theme')
                ->each(function (Crawler $themelist) use (&$plugin) {


                    $plugin['name']         = $themelist->filter('h2.theme-title')->text();
                    $plugin['downloadlink'] = $themelist->filter('a.theme-thumb')->attr('href');


                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['4'];

                    $plugin['screenshoturl'] = $themelist->attr('data-three-columns-image');


                    // Go to full plugin page to get description
                    try {

                        $crawlerThemefullPage = $this->goutteClient->request(
                            'GET',
                            $plugin['downloadlink']
                        );

                        $plugin['description'] = trim($crawlerThemefullPage
                            ->filter('div.single_excerpt')
                            ->text());

                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                    
                    $plugin['previewlink'] = 'https://demo.mythemeshop.com/' . $plugin['uniqueidentifier'] . '/';

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
