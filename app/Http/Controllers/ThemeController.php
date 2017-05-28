<?php

namespace App\Http\Controllers;

use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;

/**
 * Class ThemeController.
 */
class ThemeController extends Controller
{
    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * @var ThemeMetaRepository
     */
    protected $themeMeta;

    /**
     * ThemeController constructor.
     *
     * @param ThemeRepository     $theme
     * @param ThemeMetaRepository $themeMeta
     */
    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta = null)
    {
        $this->theme     = $theme;
        $this->themeMeta = $themeMeta;
    }


    /**
     * Scrape theme from Themeforest.
     *
     * @param int $page
     */
    public function scrapeThemeForest($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Themeforest\Theme($this->theme))->scrape($page);
        }

    }


    /**
     * Scrape theme from Creative Market.
     *
     * @param int $page
     */
    public function scrapeCreativemarket($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\CreativeMarket\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from Mojo
     *
     * @param int $page
     */
    public function scrapeMojo($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Mojo\Theme($this->theme))->scrape($page);
        }

    }


    /**
     *  Scrape theme from WordPress official repository.
     */
    public function scrapeWordPress()
    {
        (new \App\Scrape\WordPress\Theme($this->theme))->scrape();
    }

    /**
     * ThemeMeta Theme Alias.
     */
    public function scrapeThemeMeta()
    {
        (new \App\Scrape\ThemeMeta($this->theme, $this->themeMeta))->themeforest();
    }
}
