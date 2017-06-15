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
     * Scrape plugin from different providers
     *
     * @param int $page
     * @param     $provider
     *
     * @throws \Exception
     */
    public function scrapePlugin($page = 1, $provider)
    {

        $pages    = explode('-', $page);
        $provider = "\\App\\Scrape\\{$provider}\\Plugin";

        if ( ! class_exists($provider)) {
            throw new \Exception('The plugin provider ' . $provider . ' does not exist');
        }

        if (count($pages) == 1) {
            (new $provider($this->plugin))->scrape($page);
        }

        foreach (range($pages[0], $pages[1]) as $page) {
            (new $provider($this->plugin))->scrape($page);
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
