<?php

namespace App\Scrape\Themeforest;

use App\Repositories\Plugin\PluginRepository;
use App\Scrape\ScraperInterface;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Plugin implements ScraperInterface
{

    /**
     * An instance of Theme Repository.
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
        $this->plugin = $plugin;
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {
        $pageToCrawl = 'https://api.envato.com/v1/discovery/search/search/item?site=codecanyon.net&category=wordpress&sort_by=date&page=' . $page;
        echo "Page:$pageToCrawl";
        echo br();

        $client  = \App::make('goutte'); // Goutte Client
        $request = $client->getClient()->request('GET', $pageToCrawl,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('THEMEFOREST_API_KEY'),
                ],
            ]);

        $plugins = json_decode($request->getBody()->getContents());


        $data = [];


        foreach ($plugins->matches as $plugin) {
            $demoUrl = null;

            $keyFound = array_search('demo-url', array_column($plugin->attributes, 'name'));


            if ($keyFound) {
                $demoUrl = $plugin->attributes[$keyFound]->value;
            }


            $screenshotUrl = '';
            if (isset($plugin->previews->icon_with_landscape_preview->landscape_url)) {
                $screenshotUrl = $plugin->previews->icon_with_landscape_preview->landscape_url;
            } elseif (isset($plugin->previews->icon_with_video_preview->landscape_url)) {
                $screenshotUrl = $plugin->previews->icon_with_video_preview->landscape_url;
            }


            $categories               = explode('/', $plugin->classification);
            $category                 = end($categories);
            $data['provider']         = 'codecanyon.net';
            $data['type']             = 'premium';
            $data['uniqueidentifier'] = $plugin->id;
            $data['name']             = $plugin->name;
            $data['screenshoturl']    = $screenshotUrl;
            $data['downloadlink']     = isset($plugin->previews->live_site) ? $plugin->previews->live_site->url : null;
            $data['description']      = trim($plugin->description);
            $data['previewlink']      = $demoUrl;
            $data['category']         = $category;

            if ($this->plugin->save($data)) {
                echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' saved successfully';
            } else {
                echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' already exists in database.';
            }
            echo br();
            unset($data);

        }

    }
}
