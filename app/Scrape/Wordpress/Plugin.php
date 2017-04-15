<?php

namespace App\Scrape\WordPress;


use App\Models\Plugin as PluginModel;
use App\Repositories\Plugin\PluginRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
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


    /**
     * Scrape WordPress.org
     */
    public function scrape()
    {


        $this->crawler = $this->goutteClient->request(
            'GET',
            'http://plugins.svn.wordpress.org/'
        );


        $plugin = [];

        // The plugin name
        $this->crawler->filter('li')
                      ->each(function ($pluginName) use (&$plugin) {
                          $plugin['name'] = $pluginName->text();
                          $url            = 'https://wordpress.org/plugins/' . $plugin['name'];


                          $crawlerPluginfullPage = $this->goutteClient->request(
                              'GET',
                              $url
                          );

                          $plugin['url']      = $url;
                          $plugin['provider'] = 'wordpress.org';
                          $plugin['type']     = 'free';


                          // Get the Preview URL
                          $crawlerPluginfullPage->filter('#main')
                                                ->each(function ($content) use (& $plugin) {


                                                    // Get the plugin name
                                                    $content->filter('.plugin-title')
                                                            ->each(function ($content) use (& $plugin) {
                                                                $plugin['name']             = trim($content->text());
                                                                $plugin['screenshotUrl']    = 'https://ps.w.org/' . $plugin['name'] . '/assets/icon-128x128.png';
                                                                $plugin['uniqueidentifier'] = $plugin['name'];
                                                            });


                                                    // Get the description
                                                    $content->filter('#description')
                                                            ->each(function ($content) use (& $plugin) {
                                                                $plugin['description'] = trim($content->text());
                                                            });

                                                    $tags = [];
                                                    // Get the description
                                                    $content->filter('.tags a')
                                                            ->each(function ($content) use (& $plugin, &$tags) {
                                                                $tags[] = $content->text();

                                                            });
                                                    $plugin['category'] = implode(',', $tags);


                                                });

                          $this->plugin->save($plugin);


                      });
    }


}