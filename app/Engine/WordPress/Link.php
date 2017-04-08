<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:32
 */

namespace App\Engine\WordPress;

use App\Engine\SiteAnatomy;

class Link extends WordPressAbstract {


	public function check( SiteAnatomy $siteAnatomy ) {
//// check presence of absolute path such as readme, buttons.css , license.txt
		dd( "Well, checking for links.." );
		$this->next( $engine );
	}
}