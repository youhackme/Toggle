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

class Plugin  extends WordPressAbstract{
// * ways to check for presence of plugins:
	//   - based on urls e.g wp-content/plugins/w3totalcache
	//   - based on class names and ids
	//   - Based on headers
	//   - html comments such as "html": "<!--[^>]+WP-Super-Cache",
	//   -

	public function check( SiteAnatomy $siteAnatomy ) {

		$this->setScore( '0', "Well, no footprint in plugins" );

		return $this;
	}

}