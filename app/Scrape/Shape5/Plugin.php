<?php

namespace App\Scrape\Shape5;

use App\Scrape\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Plugin\PluginRepository;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26.
 */
class Plugin implements ScraperInterface
{
    /**
     * Goutte Client.
     *
     * @var
     */
    private $goutteClient;

    /**
     * An instance of Plugin Repository.
     *
     * @var PluginRepository
     */
    protected $plugin;

    /**
     * Plugin constructor.
     *
     * @param PluginRepository $plugin
     */
    public function __construct(PluginRepository $plugin)
    {
        $this->plugin       = $plugin;
        $this->goutteClient = \App::make('goutte');
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {
        if ($page == '1') {
            $pageToCrawl = 'https://www.shape5.com/wordpress/club_plugins/';
        } else {
            $pageToCrawl = 'https://www.shape5.com/wordpress/club_plugins/page_' . $page . '.html';
        }


        echo "Page: $pageToCrawl" . br();

        $crawler = $this->goutteClient->request(
            'GET',
            $pageToCrawl
        );

        $plugin             = [];
        $plugin['provider'] = 'shape5.com';
        $plugin['type']     = 'premium';


        $crawler->filter('div.s5_contentlistoutter')
                ->each(function (Crawler $pluginlist) use (&$plugin) {


                    $plugin['name'] = trim($pluginlist->filter('a.contentpagetitle')->text());

                    $plugin['downloadlink'] = $pluginlist->filter('a.contentpagetitle')->attr('href');


                    $uniqueidentifier = explode('/', $plugin['downloadlink']);

                    $plugin['uniqueidentifier'] = $uniqueidentifier['5'];


                    $imagePath = $pluginlist->filter('div.theme_image_wrap_inner  img')
                                            ->attr('src');
                    if (str_contains($imagePath, 'http')) {
                        $plugin['screenshoturl'] = $imagePath;
                    } else {

                        $plugin['screenshoturl'] = 'https://www.' . $plugin['provider'] . $imagePath;
                    }

                    $previewHtml = trim($pluginlist
                        ->filter('.theme_image_buttons')
                        ->html());

                    $previewlink = '';
                    if (preg_match('/window.open[(][\'](\S+)[\'][)]["][>]/', $previewHtml, $match)) {
                        $previewlink = $match[1];
                    }

                    $plugin['previewlink'] = str_replace(
                        'http://www.shape5.com/demo/index.php?',
                        'http://www.shape5.com/demo/',
                        $previewlink
                    );


                    if ($this->plugin->save($plugin)) {
                        echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' saved successfully';
                    } else {
                        echo '[' . getMemUsage() . ']' . $plugin['name'] . '(' . $plugin['uniqueidentifier'] . ')' . ' already exists in database . ';
                    }
                    echo br();


                    unset($plugin);

                });


    }
}
