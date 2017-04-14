<?php

namespace App\Http\Controllers;

use App\Repositories\Plugin\PluginRepository;

class PluginController extends Controller
{


    /**
     * An instance of Plugin Repository
     * @var PluginRepository
     */
    protected $plugin;


    public function __construct(PluginRepository $plugin)
    {
        $this->plugin = $plugin;
    }


    public function scrapeThemeForest($page = 1)
    {

        $pages = explode('-', $page);

        foreach (range($pages[0], $pages[1]) as $page) {

            (new \App\Scrape\Themeforest\Plugin($this->plugin))->scrape($page);

        }
    }

    public function scrapeWordPress()
    {
        (new \App\Scrape\WordPress\Plugin($this->plugin))->scrape();

    }
}
