<?php

namespace App\Scrape\YooTheme;

use App\Scrape\ScraperInterface;
use App\Repositories\Theme\ThemeRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Theme implements ScraperInterface
{

    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * Theme constructor.
     *
     * @param ThemeRepository $theme
     */
    public function __construct(ThemeRepository $theme)
    {
        $this->theme        = $theme;
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {

        $pageToCrawl = 'https://demo.yootheme.com/wordpress/';

        echo "Page: $pageToCrawl" . br();


        $theme             = [];
        $theme['provider'] = 'yootheme.com';
        $theme['type']     = 'premium';

        //INSERT JSON HERE
        $jsonResponse = '{}';
        $templates    = json_decode($jsonResponse);
        foreach ($templates as $template) {

            $theme['name']          = $theme['uniqueidentifier'] = $template->name;
            $theme['screenshoturl'] = 'https://demo.yootheme.com' . $template->default_preset->thumbnail;
            $theme['description']   = $theme['name'] . ' is a Premium WordPress theme from ' . $theme['provider'];
            $theme['downloadlink']  = 'https://demo.yootheme.com/wordpress/' . strtolower($theme['uniqueidentifier']);
            $previewUrl             = $template->default_preset->url;
            $previewUrl             = str_replace(['joomla', 'index.php'], ['wordpress', ''], $previewUrl);
            $theme['previewlink']   = 'https://demo.yootheme.com' . $previewUrl;

            if ($this->theme->save($theme)) {
                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' saved successfully';
            } else {
                echo '[' . getMemUsage() . ']' . $theme['name'] . '(' . $theme['uniqueidentifier'] . ')' . ' already exists in database.';
            }

        }


    }
}
