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

class Theme extends WordPressAbstract {
// * detect theme based on
	// -- screenshot hash
	// -- theme alias => wp-content/themes/theme-name
	// -- meta data in style sheets

	public function check( SiteAnatomy $siteAnatomy ) {

		$this->setScore( '0', "Well, no footprint in theme" );

		return $this;
	}
}