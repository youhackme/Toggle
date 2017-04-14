<?php

namespace App\Http\Controllers;

use App\Repositories\ThemeRepository;
class ThemeController extends Controller
{

    /**
     * An instance of Theme Repository
     * @var ThemeRepository
     */
    protected $theme;


    public function __construct(ThemeRepository $theme)
    {
        $this->theme = $theme;
    }


    public function scrapeThemeForest($page = 1)
    {
        $pages = explode('-', $page);

        foreach (range($pages[0], $pages[1]) as $page) {

            (new \App\Scrape\Themeforest\Theme( $this->theme))->scrape($page);

        }

    }

    public function scrapeWordPress()
    {
        (new \App\Scrape\WordPress\Theme( $this->theme))->scrape();

    }


}
