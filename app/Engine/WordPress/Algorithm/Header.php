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

class Header extends WordPressAbstract {
// Check for headers such as Powered by W3 total cache
	// Powered by X
	// This will confirm WP

	public function check( SiteAnatomy $siteAnatomy ) {

		$this->setScore( '0', "Well, no footprint in headers" );

		return $this;

	}

}