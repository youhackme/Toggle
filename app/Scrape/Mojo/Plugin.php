<?php

namespace App\Scrape\Mojo;

use App\Scrape\ScraperInterface;
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
        $this->plugin = $plugin;
    }

    /**
     * Scrape plugin.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {

        $pageToCrawl = 'https://api.mojomarketplace.com/api/v2/items?category=wordpress&type=plugins&count=20&order=popular&page=' . $page;

        echo "Page: $pageToCrawl" . br();

        $client  = \App::make('goutte'); // Goutte Client
        $request = $client->getClient()->request('GET', $pageToCrawl);

        $plugins = json_decode($request->getBody()->getContents());
        $data    = [];
        if ($plugins->status == 'success') {
            foreach ($plugins->items as $item) {

                $data['provider']         = 'mojomarketplace.com';
                $data['type']             = 'premium';
                $data['uniqueidentifier'] = $item->id;
                $data['name']             = $item->name;
                $data['screenshoturl']    = $item->images->square_thumbnail_url;
                $data['downloadlink']     = str_replace('http://api.', 'https://', $item->page_url);
                $data['description']      = is_array($item->features) ? trim(implode(',', $item->features)) : '';
                $data['previewlink']      = $item->demo_url;
                //Skip a specific plugin with too long preview url
                if ($data['uniqueidentifier'] != '565f506a-aaac-4997-8787-4fcd0a141f38') {
                    if ($this->plugin->save($data)) {
                        echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' saved successfully';
                    } else {
                        echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' already exists in database.';
                    }
                }

                echo br();
                unset($data);
            }
        }
    }
}