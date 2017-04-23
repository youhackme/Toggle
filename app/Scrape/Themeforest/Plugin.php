<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */

namespace App\Scrape\Themeforest;


use App\Repositories\Plugin\PluginRepository;
use App\Scrape\ScraperInterface;

/**
 * Scrape plugins from Themeforest
 * @package App\Scrape\Themeforest
 */
class Plugin implements ScraperInterface
{


    /**
     * Store plugin meta data
     * @var array
     */
    private $crawler;

    /**
     * An instance of goutte Client
     * @var
     */
    private $goutteClient;


    /**
     * An instance of Plugin Repository
     * @var PluginRepository
     */
    protected $plugin;


    public function __construct(PluginRepository $plugin)
    {
        $this->plugin       = $plugin;
        $this->goutteClient = \App::make('goutte');
    }


    public function scrape($page = 1)
    {


        $pageToCrawl = 'https://codecanyon.net/category/wordpress?page=' . $page . '&referrer=search&sort=sales&utf8=✓&view=list';
        echo "Scraping page: $pageToCrawl";
        echo br();


        $this->crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );


        $plugin             = [];
        $plugin['type']     = 'premium';
        $plugin['provider'] = 'codecanyon.net';


        $this->crawler->filter('li.js-google-analytics__list-event-container')
                      ->each(function ($pluginlist) use (&$plugin) {


                          // The plugin Unique id
                          $plugin['uniqueidentifier'] = $pluginlist->attr('data-item-id');

                          // The plugin name
                          $plugin['name'] = $pluginlist->filter('h3')->text();

                          // The plugin preview  screenshot
                          $plugin['screenshoturl'] = $pluginlist->filter('img.preload')->attr('data-preview-url');

                          // The plugin category
                          $plugin['category'] = $pluginlist->filter('[itemprop="genre"]')->text();


                          // Click on each plugin name and go to their plugin page details
                          if ( ! empty(trim($plugin['name']))) {


                              // Navigate to the plugin full page
                              $pluginFullPageUrl = $pluginlist->filter('h3 a')->attr('href');

                              $crawlerPluginfullPage = $this->goutteClient->request(
                                  'GET',
                                  'https://' . $plugin['provider'] . $pluginFullPageUrl
                              );


                              // Get the plugin description
                              $plugin['description'] = $crawlerPluginfullPage
                                  ->filter('div.item-description')
                                  ->text();

                              try {


                                  // Get the preview url of the plugin
                                  $livePreviewLink = $crawlerPluginfullPage
                                      ->filter('.live-preview')
                                      ->attr('href');

                                  $plugin['downloadlink'] = $livePreviewLink;
                                  //Click on the preview link button on the plugin full page
                                  $crawlerPluginPreviewLink = $this->goutteClient->request(
                                      'GET',
                                      $livePreviewLink
                                  );

                                  // Get the plugin url hosted by the author
                                  $plugin['previewlink'] = $crawlerPluginPreviewLink
                                      ->filter('div.preview__action--close a')
                                      ->attr('href');


                                  $this->plugin->save($plugin);
                                  unset($plugin);


                              } catch (\InvalidArgumentException $e) {
                                  echo $e->getMessage() . br();
                                  echo "This plugin does not have a demo page: " . json_encode($plugin['uniqueidentifier']) . br();
                                  //Save plugin data even if it is partially filled
                                  unset($plugin['previewlink']);
                                  $this->plugin->save($plugin);

                              }
                          } else {
                              echo "No data for" . $plugin['uniqueidentifier'];
                              echo "<br/> \n";
                          }

                      });

    }

}