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

class Uri extends WordPressAbstract {
	// Check presence of wp-content
	// Check presence of wp-include

	public function check( SiteAnatomy $siteAnatomy ) {

		$this->setScore( '0', "Well, no footprint in Uri" );

		return $this;
	}

}