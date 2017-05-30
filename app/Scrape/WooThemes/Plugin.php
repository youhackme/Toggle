<?php

namespace App\Scrape\WooThemes;

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

        $pageToCrawl = 'https://woocommerce.com/product-category/woocommerce-extensions/page/' . $page . '/';

        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'woocommerce.com';
        $plugin['type']     = 'premium';


        $crawler->filter('div.extensions-archive-results > ul.products li.product')
                ->each(function (Crawler $themelist) use (&$plugin) {

                    if ( ! $themelist->filter('li.promo-block')->count()) {
                        try {


                            $plugin['name'] = $themelist->filter('span.extension-header h3')->text();


                            $plugin['downloadlink'] = $themelist->filter('a')->attr('href');


                            $uniqueidentifier           = explode('/', $plugin['downloadlink']);
                            $plugin['uniqueidentifier'] = $uniqueidentifier['4'];


                            $plugin['screenshoturl'] = '';
                            if ($themelist->filter('span.extension-header img')->count()) {
                                $plugin['screenshoturl'] = $themelist->filter('span.extension-header img')->attr('src');
                            }


                            $plugin['description'] = '';
                            if ($themelist->filter('a p')->count()) {
                                $plugin['description'] = trim($themelist->filter('a p')->text());
                            }


                            $plugin['previewlink'] = $plugin['downloadlink'];


                            if ($this->plugin->save($plugin)) {
                                echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' saved successfully';
                            } else {
                                echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' already exists in database.';
                            }

                        } catch (\Exception $e) {
                            dd($e);
                        }

                        echo br();

                    }

                    unset($plugin);

                });


    }
}
