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

    protected $themeMeta;

    /**
     * ThemeController constructor.
     *
     * @param ThemeRepository     $theme
     * @param ThemeMetaRepository $themeMeta
     */
    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta = null)
    {
        $this->theme = $theme;
        $this->themeMeta = $themeMeta;
    }

    /**
     * ThemeMeta theme from Themeforest.
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
     * ThemeMeta WordPress theme.
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
