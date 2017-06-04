<?php

namespace App\Scrape\TemplateMonster;

use App\Scrape\ScraperInterface;
use GuzzleHttp\Client;
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
    protected $data;

    /**
     * Theme constructor.
     *
     * @param ThemeRepository $data
     */
    public function __construct(ThemeRepository $data)
    {
        $this->theme = $data;
    }

    /**
     * Scrape theme.
     *
     * @param int $page
     */
    public function scrape($page = 1)
    {
        $appPath             = storage_path('app/other');
        $templateMonsterFile = $appPath . '/t_info.xml';


        $data = [];


        $xml = new \XMLReader();
        $xml->open($templateMonsterFile);


        while ($xml->read()) {


            if ($xml->nodeType == \XMLReader::ELEMENT) {


                if ($xml->name == 'software_required') {
                    if ($data['type'] == 'WordPress Themes') {

                        $result = $this->scrapeDetails($data['downloadlink']);
                        if ($result) {
                            if ($this->theme->save($result)) {
                                echo '[' . getMemUsage() . ']' . $result['name'] . '(' . $result['uniqueidentifier'] . ')' . ' saved successfully';
                            } else {
                                echo '[' . getMemUsage() . ']' . $result['name'] . '(' . $result['uniqueidentifier'] . ')' . ' already exists in database.';
                            }
                            echo br();
                        }
                        unset($data);

                    }

                }

                if ($xml->name == 'type_name') {
                    $xml->read();
                    $data['type'] = $xml->value;
                }

                if ($xml->name == 'id') {
                    $xml->read();
                    $data['uniqueidentifier'] = $xml->value;
                    $data['downloadlink']     = 'https://www.templatemonster.com/wordpress-themes/' . $data['uniqueidentifier'] . '.html';
                }


            }
        }
    }

    /**
     * @param $downloadLink
     *
     * @return array
     */
    public function scrapeDetails($downloadLink)
    {

        $identifier = explode('/', $downloadLink);
        $identifier = str_replace('.html', '', $identifier[4]);
        if ($identifier < 40957) {
            return false;
        }

        $theme             = [];
        $theme['provider'] = 'templatemonster.com';
        $theme['type']     = 'premium';

        $goutteClient = \App::make('goutte');
        $crawler      = $goutteClient->request(
            'GET',
            $downloadLink
        );


        echo $downloadLink . br();

        if ($crawler->filter('h1.preview-heading')->count() == 0) {
            echo 'The theme name cannot be determined' . br();

            return false;
        }
        $theme['name']             = $crawler->filter('h1.preview-heading')->text();
        $theme['uniqueidentifier'] = $crawler->filter('strong[itemprop="productID"]')->text();
        $theme['screenshoturl']    = $crawler->filter('img.js-preview-scr')->attr('data-original');
        $theme['downloadlink']   = $downloadLink;
        $theme['previewlink'] = 'https://livedemo00.template-help.com/wordpress_' . $theme['uniqueidentifier'] . '/';


        if ($crawler->filter('p[itemprop="description"]')->count()) {
            $theme['description'] = $crawler->filter('p[itemprop="description"]')->text();
        } else {
            $theme['description'] = '';
        }


        if ($crawler->filter('div.aside-information h2')->count() != 0) {
            echo 'This theme has been discontinued.' . br();

            return false;
        }

        return $theme;

    }
}
