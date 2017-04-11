<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:31
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\WordPress\WordPressAbstract;
use App\Engine\SiteAnatomy;

class Html extends WordPressAbstract
{

    /**
     * Inject an instance of \App\Engine\SiteAnatomy
     * @var
     */
    public $siteAnatomy;

    /**
     * @param SiteAnatomy $siteAnatomy
     *
     * @return $this
     */
    public function check(SiteAnatomy $siteAnatomy)
    {
        $this->siteAnatomy = $siteAnatomy;

        $this->checkInMetatags();
        $this->checkUri();

        return $this;

    }


    /**
     * Check for presence of WordPress in meta generator
     */
    public function checkInMetatags()
    {
        if (isset($this->siteAnatomy->metas['generator'])) {
            foreach ($this->siteAnatomy->metas['generator'] as $metatag) {
                if (preg_match('/WordPress/u', $metatag)) {
                    $this->assertWordPress('metatag');
                }
            };
        }
    }

    /**
     * Check presence of specific Uri in source code e.g wp-content, wp-includes etc
     */
    public function checkUri()
    {

        if (preg_match('/wp-content|wp-includes/i', $this->siteAnatomy->html, $matches)) {
            $this->assertWordPress('uri');
        }
    }

}