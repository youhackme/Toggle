<?php

namespace App\Http\Controllers;

use App\Repositories\Theme\ThemeRepository;

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
     * ThemeController constructor.
     *
     * @param ThemeRepository $theme
     */
    public function __construct(ThemeRepository $theme)
    {
        $this->theme = $theme;
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
     * Scrape WordPress theme.
     */
    public function scrapeWordPress()
    {
        (new \App\Scrape\WordPress\Theme($this->theme))->scrape();
    }

    /**
     * Scrape Theme Alias.
     */
    public function scrapeThemeAlias()
    {
        (new \App\Scrape\Themeforest\Theme($this->theme))->extractThemeAlias();
    }
}
