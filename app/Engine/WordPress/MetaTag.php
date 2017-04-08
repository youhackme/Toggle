<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:30
 */

namespace App\Engine\WordPress;

use App\Engine\SiteAnatomy;

class MetaTag extends WordPressAbstract {


	public function check( SiteAnatomy $siteAnatomy ) {

		if ( ! $siteAnatomy->metas ) {
			throw new \Exception( "Well this site does not have any meta tags, move on to next check" );
		}

		$this->next( $siteAnatomy );
	}

	// Check for powered by wordpress
	// Check also for presence of plugins in meta tags to confirm WP

}