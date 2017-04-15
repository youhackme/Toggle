<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */

namespace App\Scrape\Themeforest;


use App\Models\Plugin as PluginModel;
use App\Repositories\Plugin\PluginRepository;


/**
 * Scrape plugins from Themeforest
 * @package App\Scrape\Themeforest
 */
class Plugin
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


        $pageToCrawl = 'https://codecanyon.net/category/wordpress?page=' . $page;
        echo "Scraping page: $pageToCrawl";
        echo br();


        $this->crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );


        $plugin = [];


        $this->crawler->filter('li.js-google-analytics__list-event-container')
                      ->each(function ($themelist) use (&$plugin) {


                          // The plugin Unique id
                          $plugin['uniqueidentifier'] = $themelist->attr('data-item-id');

                          // The plugin name
                          $themelist->filter('h3')
                                    ->each(function ($themeTitle) use (&$plugin) {
                                        $plugin['name'] = $themeTitle->text();
                                    });

                          // The plugin preview  screenshot
                          $themelist->filter('img.preload')
                                    ->each(function ($themeImage) use (&$plugin) {
                                        $plugin['screenshotUrl'] = $themeImage->attr('data-preview-url');
                                    });

                          // The plugin preview  screenshot
                          $themelist->filter('[itemprop="genre"]')
                                    ->each(function ($themeImage) use (&$plugin) {
                                        $plugin['category'] = $themeImage->text();
                                    });


                          // Click on each plugin name and go to their plugin page details
                          if ( ! empty(trim($plugin['name']))) {

                              try {
                                  $link                       = $this->crawler->selectLink(trim($plugin['name']))->link();
                                  $this->crawlerThemefullPage = $this->goutteClient->click($link);


                                  // Get the Preview URL
                                  $this->crawlerThemefullPage->filter('a.live-preview')
                                                             ->each(function ($themePreviewlink) use (& $plugin) {
                                                                 $plugin['downloadlink'] = $themePreviewlink->attr('href');
                                                             });


                                  // Get the plugin description
                                  $this->crawlerThemefullPage->filter('div.item-description')
                                                             ->each(function ($themeDescription) use (&$plugin) {
                                                                 $plugin['description'] = $themeDescription->text();
                                                             });

                                  // Click on the preview link
                                  $previewlink                   = $this->crawlerThemefullPage->selectLink('Live Preview')->link();
                                  $this->crawlerThemePreviewLink = $this->goutteClient->click($previewlink);

                                  // Get the plugin url hosted by the author
                                  $this->crawlerThemePreviewLink->filter('div.preview__action--close a')
                                                                ->each(function ($themeDescription) use (&$plugin
                                                                ) {
                                                                    $plugin['url'] = $themeDescription->attr('href');
                                                                });


                                  $this->plugin->save($plugin);


                              } catch (\InvalidArgumentException $e) {
                                  echo "Well, it sucks. Cannot scrape: " . json_encode($plugin['uniqueidentifier']);
                                  echo "<br/> \n";
                              }
                          } else {
                              echo "No data for" . $plugin['uniqueidentifier'];
                              echo "<br/> \n";
                          }

                      });


    }


}