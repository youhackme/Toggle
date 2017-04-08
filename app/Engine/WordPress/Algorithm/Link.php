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


class Link extends WordPressAbstract {

//// check presence of absolute path such as readme, buttons.css , license.txt
	///wp-includes/wlwmanifest.xml
	// WordPress version : wp-links-opml.php
	// /wp-json/


	public function check( SiteAnatomy $siteAnatomy ) {

		$this->setScore( '0', "Well, no footprint in links" );

		return $this;
	}


}