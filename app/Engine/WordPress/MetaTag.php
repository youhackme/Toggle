<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:30
 */

namespace App\Engine\WordPress;


class MetaTag extends WordPressDetector {


	public function check( WordPress $wordpress ) {
		if ( ! $wordpress->$metaTag ) {
			throw new \Exception( "Do not check for meta tags" );
		}
		$this->next( $wordpress );
	}

	// Check for powered by wordpress
	// Check also for presence of plugins in meta tags to confirm WP

}