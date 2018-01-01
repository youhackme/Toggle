<?php

namespace App\Engine\WordPress;

/*
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 22:16
 */
use App\Engine\SiteAnatomy;
use Bugsnag\Report;

/**
 * Handle the algorithm to detect if a site is using WordPress.
 */
class WordPress
{
    /**
     * An instance of Site Anatomy.
     *
     * @var
     */
    public $siteAnatomy;
    /**
     * The order each algorithm should be checked.
     *
     * @var array
     */
    protected $algorithms = [
        \App\Engine\WordPress\Algorithm\Html::class,
        \App\Engine\WordPress\Algorithm\Theme::class,
        \App\Engine\WordPress\Algorithm\Plugin::class,
        \App\Engine\WordPress\Algorithm\Robot::class,
        \App\Engine\WordPress\Algorithm\Link::class,
        \App\Engine\WordPress\Algorithm\Screenshot::class,
        \App\Engine\WordPress\Algorithm\Version::class,

    ];
    /**
     * Are you WordPress?!
     *
     * @var
     */
    private $isWordPress;
    /**
     * Attempt to detect WordPress version.
     *
     * @var
     */
    private $version;
    /**
     * Attempt to detect Theme screenshot.
     *
     * @var
     */
    private $screenshot;
    /**
     * Attempt to make a unique list of plugins out of those algos.
     *
     * @var
     */
    private $plugins;
    /**
     * Attempt to determine the correct theme name out of those algos.
     *
     * @var
     */
    private $theme;

    /**
     * WordPress constructor.
     *
     * @param SiteAnatomy $siteAnatomy
     */
    public function __construct(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;
        $this->detect();
    }

    /**
     * Detect CMS based on each algorithm.
     *
     * @return array
     */
    public function detect()
    {
        foreach ($this->algorithms as $algorithm) {
            $wordPress           = (new $algorithm())->check($this->siteAnatomy);
            $this->isWordPress[] = $wordPress->getWordPressAssertions();
            $this->theme[]       = $wordPress->getTheme();
            $this->plugins[]     = $wordPress->getPlugin();
            $this->screenshot[]  = $wordPress->getScreenshot();
            $this->version[]     = $wordPress->getVersion();
        }
    }

    /**
     * Reveal the WordPress Bolt N Nuts.
     *
     * @return string
     */
    public function details()
    {

        if ($this->isWordPress()) {

            $app = (new \App\Engine\App())
                ->setName("WordPress")
                ->setConfidence("100")
                ->setVersion($this->version())
                ->setIcon(env('APP_URL') . "/storage/icons/WordPress.svg")
                ->setWebsite("http://wordpress.org")
                ->setCategories(["Blogs", "CMS"]);

            foreach ($this->extraThemeInfos() as $theme) {
                $app->setTheme($theme);
            }

            foreach ($this->plugins() as $plugin) {
                $app->setPlugin($plugin);
            }

            return $app;
        }

        return false;

    }

    /**
     * Are you WordPress? You have the last word!
     *
     * @return bool
     */
    public function isWordPress(): bool
    {
        if ( ! empty(array_collapse($this->isWordPress))) {
            return true;
        }

        return false;
        // Cycle through each algorithm and find out through assertWordPress
    }

    /**
     * Tell us the real WordPress version.
     *
     * @return bool
     */
    private function version()
    {

        $version = array_unique(array_collapse($this->version));
        if (count($version) > 1) {
            \Bugsnag::notifyError('Anomaly', 'More than one version detected',
                function (Report $report) use ($version) {
                    $report->setSeverity('info');
                    $report->setMetaData([
                        'versions' => $version,
                        'other'    => json_encode($this),
                    ]);
                });
        }

        return implode('/', $version);
    }

    /**
     * Fetch description from database
     * @return array|bool|int|string
     */
    private function extraThemeInfos(): array
    {
        $themes    = $this->theme();
        $allThemes = [];

        if ( ! empty($themes)) {

            foreach ($themes as $themeAlias => &$details) {

                $theme = (new \App\Engine\Theme()
                )->setName($themeAlias)
                 ->setSlug($themeAlias);


                if (isset($details['screenshot']['hash'])) {
                    $theme->setScreenshotHash($details['screenshot']['hash']);
                }

                if (isset($details['screenshot']['url'])) {
                    $theme->setScreenshotUrl($details['screenshot']['url']);
                }


                $allThemes[] = $theme->compute();
            }

        }

        return $allThemes;
    }

    /**
     * Get the theme name, you have the last word, duh.
     *
     * @return array|bool|int|string
     */
    private function theme()
    {
        $themeAlias = array_collapse($this->theme);

        if ( ! empty($themeAlias)) {
            if (count($themeAlias) > 1) {
                \Bugsnag::notifyError('Anomaly', 'More than one theme detected',
                    function (Report $report) use ($themeAlias) {
                        $report->setSeverity('info');
                        $report->setMetaData([
                            'themes' => $themeAlias,
                            'other'  => json_encode($this),
                        ]);
                    });
            }

            return $themeAlias;
        }

        return false;
        // Cycle through each algorithm and find out through getTheme
        // Find more information from theme database now
    }

    /**
     * Get the list of plugins being used, again, you have the last Word.
     *
     * @return array
     */
    private function plugins(): array
    {

        $allPlugins = [];
        $plugins    = array_collapse($this->plugins);

        if ( ! empty($plugins)) {
            foreach ($plugins as &$plugin) {


                $slug                  = $plugin['slug'];
                $plugin['description'] = null;
                $plugin['name']        = ucwords(str_replace('-', ' ', $slug));


                $allPlugins[] = (new \App\Engine\Plugin()
                )->setName($plugin['name'])
                 ->setSlug($slug)
                 ->compute();


            }
        }


        return $allPlugins;


        // Cycle through each algorithm and find out through getPlugin
        // Find more information from plugin database now
    }
}
