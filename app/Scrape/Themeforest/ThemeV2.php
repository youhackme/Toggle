<?php

namespace App\Scrape\Themeforest;

use App\Scrape\ScraperInterface;

use App\Repositories\Theme\ThemeRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class ThemeV2 implements ScraperInterface
{
    /**
     * Store theme meta data.
     *
     * @var array
     */
    private $crawler;

    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    public function __construct(ThemeRepository $theme)
    {
        $this->theme        = $theme;
        $this->goutteClient = \App::make('goutte');
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {

        //$pageToCrawl = 'https://api.envato.com/v1/discovery/search/search/item?category=' . $categoryName . '&page=' . $page . '&site=themeforest.net';
        $pageToCrawl = 'https://api.envato.com/v1/discovery/search/search/item?site=themeforest.net&category=wordpress&sort_by=date&page=' . $page . '';
        echo "Page:$page";
        echo br();

        $client  = \App::make('goutte'); // Goutte Client
        $request = $client->getClient()->request('GET', $pageToCrawl,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('THEMEFOREST_API_KEY'),
                ],
            ]);

        $themes = json_decode($request->getBody()->getContents());


        $data = [];


        foreach ($themes->matches as $theme) {
            $demoUrl = null;

            $keyFound = array_search('demo-url', array_column($theme->attributes, 'name'));


            if ($keyFound) {
                $demoUrl = $theme->attributes[$keyFound]->value;
            }

            $data['provider']         = 'themeforest.net';
            $data['type']             = 'premium';
            $data['uniqueidentifier'] = $theme->id;
            $data['name']             = $theme->name;
            $data['screenshoturl']    = $theme->previews->icon_with_landscape_preview->landscape_url;
            $data['downloadlink']     = isset($theme->previews->live_site) ? $theme->previews->live_site->url : null;
            $data['description']      = trim($theme->description);
            $data['previewlink']      = $demoUrl;
            if ($this->theme->save($data)) {
                echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' saved successfully';
            } else {
                echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' already exists in database.';
            };
            echo br();
            unset($data);


        }

    }
}