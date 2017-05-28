<?php

namespace App\Scrape\Mojo;

use App\Scrape\ScraperInterface;
use App\Repositories\Theme\ThemeRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Theme implements ScraperInterface
{
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

    /**
     * Theme constructor.
     *
     * @param ThemeRepository $theme
     */
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

        $pageToCrawl = 'https://api.mojomarketplace.com/api/v2/items?category=wordpress&type=themes&count=20&order=popular&page=' . $page;

        echo "Page: $pageToCrawl" . br();

        $client  = \App::make('goutte'); // Goutte Client
        $request = $client->getClient()->request('GET', $pageToCrawl);

        $themes = json_decode($request->getBody()->getContents());
        $data   = [];
        if ($themes->status == 'success') {
            foreach ($themes->items as $item) {

                $data['provider']         = 'mojomarketplace.com';
                $data['type']             = 'premium';
                $data['uniqueidentifier'] = $item->id;
                $data['name']             = $item->name;
                $data['screenshoturl']    = $item->images->large_thumbnail_url;
                $data['downloadlink']     = str_replace('http://api.', 'https://', $item->page_url);
                $data['description']      = is_array($item->features) ? trim(implode(',', $item->features)) : '';
                $data['previewlink']      = $item->demo_url;
                if ($this->theme->save($data)) {
                    echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' saved successfully';
                } else {
                    echo '[' . getMemUsage() . ']' . $data['name'] . '(' . $data['uniqueidentifier'] . ')' . ' already exists in database.';
                }
                echo br();
                unset($data);
            }
        }
    }
}
