<?php

namespace App\Http\Controllers;

use App\Repositories\Plugin\PluginRepository;

/**
 * Class PluginController.
 */
class PluginController extends Controller
{
    /**
     * An instance of Plugin Repository.
     *
     * @var PluginRepository
     */
    protected $plugin;

    /**
     * PluginController constructor.
     *
     * @param PluginRepository $plugin
     */
    public function __construct(PluginRepository $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Scrape Plugin from themeforest.
     *
     * @param int $page
     */
    public function scrapeThemeForest($page = 1)
    {
        $pages = explode('-', $page);

        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Themeforest\Plugin($this->plugin))->scrape($page);
        }

    }

    /**
     * Scrape Plugin from Creative Market.
     *
     * @param int $page
     */
    public function scrapeCreativemarket($page = 1)
    {
        $pages = explode('-', $page);

        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\CreativeMarket\Plugin($this->plugin))->scrape($page);
        }

    }

    /**
     * Scrape plugin from Mojo
     *
     * @param int $page
     */
    public function scrapeMojo($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Mojo\Plugin($this->plugin))->scrape($page);
        }

    }


    /**
     * Scrape plugin from Mojo
     *
     * @param int $page
     */
    public function scrapeiThemes($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\iThemes\Plugin($this->plugin))->scrape($page);
        }

    }


    /**
     * Scrape plugin from WordPress.
     */
    public function scrapeWordPress()
    {
        (new \App\Scrape\WordPress\Plugin($this->plugin))->scrape();
    }
}
