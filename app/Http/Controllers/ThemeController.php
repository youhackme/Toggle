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
     * Scrape theme from Tesla Theme
     *
     * @param int $page
     */
    public function scrapeTesla($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Tesla\Theme($this->theme))->scrape($page);
        }

    }


    /**
     * Scrape theme from Themify
     *
     * @param int $page
     */
    public function scrapeThemify($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Themify\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from Studio Press
     *
     * @param int $page
     */
    public function scrapeStudioPress($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\StudioPress\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from Elegant Themes
     *
     * @param int $page
     */
    public function scrapeElegantThemes($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\ElegantThemes\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from IThemes
     *
     * @param int $page
     */
    public function scrapeIThemes($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\IThemes\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from My Theme Shop
     *
     * @param int $page
     */
    public function scrapeMyThemeShop($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\MyThemeShop\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from ThemeFuse
     *
     * @param int $page
     */
    public function scrapeThemeFuse($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\ThemeFuse\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from WooThemes
     *
     * @param int $page
     */
    public function scrapeWooThemes($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\WooThemes\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from ThemeIsle
     *
     * @param int $page
     */
    public function scrapeThemeIsle($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\ThemeIsle\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from CssIgniter
     *
     * @param int $page
     */
    public function scrapeCssIgniter($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\CssIgniter\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from GraphPaperPress
     *
     * @param int $page
     */
    public function scrapeGraphPaperPress($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\GraphPaperPress\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from Shape5
     *
     * @param int $page
     */
    public function scrapeShape5($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\Shape5\Theme($this->theme))->scrape($page);
        }

    }

    /**
     * Scrape theme from ThemeTrust
     *
     * @param int $page
     */
    public function scrapeThemeTrust($page = 1)
    {
        $pages = explode('-', $page);


        foreach (range($pages[0], $pages[1]) as $page) {
            (new \App\Scrape\ThemeTrust\Theme($this->theme))->scrape($page);
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
