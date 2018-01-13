<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:31.
 */

namespace App\Engine\WordPress\Algorithm;

use App\Engine\SiteAnatomy;
use App\Engine\WordPress\WordPressAbstract;

class Html extends WordPressAbstract
{
    /**
     * Inject an instance of \App\Engine\SiteAnatomy.
     *
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


        return $this;
    }

    /**
     * Check for presence of WordPress in meta generator.
     */
    public function checkInMetatags()
    {
        if (isset($this->siteAnatomy->metas['generator'])) {
            foreach ($this->siteAnatomy->metas['generator'] as $metatag) {
                if (preg_match('/WordPress/u', $metatag)) {
                    $this->assertWordPress('metatag');
                }
            }
        }
    }

}
