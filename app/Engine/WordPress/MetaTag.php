<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:30
 */

namespace App\Engine\WordPress;


class MetaTag extends WordPressDetector {


	public function check( Engine $engine ) {
		if ( ! $engine->metatags() ) {
			throw new \Exception( "Well this site does not have any meta tags, move on to next check" );
		}
		$this->next( $engine );
	}

	// Check for powered by wordpress
	// Check also for presence of plugins in meta tags to confirm WP

}