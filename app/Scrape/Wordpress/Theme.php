<?php

namespace App\Scrape\WordPress;

use App\Repositories\Theme\ThemeRepository;
use App\Scrape\ScraperInterface;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */
class Theme implements ScraperInterface
{

    /**
     * Store theme meta data
     * @var array
     */
    private $crawler;

    /**
     * Goutte Client
     * @var
     */
    private $goutteClient;


    /**
     * An instance of Theme Repository
     * @var ThemeRepository
     */
    protected $theme;


    public function __construct(ThemeRepository $theme)
    {
        $this->theme        = $theme;
        $this->goutteClient = \App::make('goutte');
    }


    /**
     * Scrape WordPress.org
     */
    public function scrape()
    {

        $this->crawler = $this->goutteClient->request(
            'GET',
            'http://plugins.svn.wordpress.org/'
        );


        $theme = [];

        // The Theme name
        $this->crawler->filter('li')
                      ->each(function ($themeName) use (&$theme) {
                          $theme['name'] = $themeName->text();

                          $theme['uniqueidentifier'] = $theme['name'];
                          $url                       = 'https://wordpress.org/themes/' . $theme['name'];
                          $theme['downloadLink']     = $url;
                          $theme['PreviewLink']      = $url;
                          $crawlerThemefullPage      = $this->goutteClient->request(
                              'GET',
                              $url
                          );

                          $responseStatus = $this->goutteClient->getResponse()->getStatus();
                          if ($responseStatus == 200) {

                              $theme['url']      = $url;
                              $theme['provider'] = 'wordpress.org';
                              $theme['type']     = 'free';

                              // Get the Preview URL
                              $crawlerThemefullPage->filter('.theme-wrap')
                                                   ->each(function ($content) use (& $theme) {


                                                       // Get the Theme name
                                                       $content->filter('.theme-name')
                                                               ->each(function ($content) use (& $theme) {
                                                                   $theme['name'] = trim($content->text());

                                                               });

                                                       $content->filter('div.screenshot img')
                                                               ->each(function ($content) use (& $theme) {
                                                                   $theme['screenshotUrl'] = trim($content->attr('src'));

                                                               });


                                                       // Get the description
                                                       $content->filter('.theme-description')
                                                               ->each(function ($content) use (& $theme) {
                                                                   $theme['description'] = trim($content->text());
                                                               });

                                                       $tags = [];
                                                       // Get the category
                                                       $content->filter('.theme-tags a')
                                                               ->each(function ($content) use (& $theme, &$tags) {
                                                                   $tags[] = $content->text();

                                                               });
                                                       $theme['category'] = substr(implode(',', $tags), 0, 150);


                                                   });

                              $this->theme->save($theme);


                          } else {
                              echo "Theme {$theme['name']} does not exist";
                              echo br();
                          }


                      });
    }


}