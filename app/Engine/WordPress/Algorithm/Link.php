<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:32
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\WordPress\WordPressAbstract;

use App\Engine\SiteAnatomy;


class Link extends WordPressAbstract
{

//// check presence of absolute path such as readme, buttons.css , license.txt
    ///wp-includes/wlwmanifest.xml
    // WordPress version : wp-links-opml.php
    // /wp-json/
    //- It should be asynchronous


    public function check(SiteAnatomy $siteAnatomy)
    {

        $this->setScore('0', "Well, no footprint in links");

        return $this;
    }

    private function commonWordPressPath()
    {
        return [
            [
                'path'      => 'readme.html',
                'searchFor' => '/WordPress/',
            ],
            [
                'path'      => 'wp-includes/wlwmanifest.xml',
                'searchFor' => '/WordPress|manifest/',
            ],
            [
                'path'      => 'wp-links-opml.php',
                'searchFor' => '/WordPress|opml/',
            ],
            [
                'path'      => 'wp-json',
                'searchFor' => '/WordPress|wp-api/',
            ],


        ];
    }


}