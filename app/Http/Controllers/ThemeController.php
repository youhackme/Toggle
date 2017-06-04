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
     * Scrape theme from different providers
     *
     * @param int $page
     * @param     $provider
     *
     * @throws \Exception
     */
    public function scrapeTheme($page = 1, $provider)
    {

        $pages    = explode('-', $page);
        $provider = "\\App\\Scrape\\{$provider}\\Theme";
        if ( ! class_exists($provider)) {
            throw new \Exception('The theme provider ' . $provider . ' does not exist');
        }
        if (count($pages) == 1) {
            (new $provider($this->theme))->scrape($pages);
        } else {
            foreach (range($pages[0], $pages[1]) as $page) {
                (new $provider($this->theme))->scrape($page);
            }
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
