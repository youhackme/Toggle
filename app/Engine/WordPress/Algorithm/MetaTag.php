<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 20:30
 */

namespace App\Engine\WordPress\Algorithm;
use App\Engine\WordPress\WordPressAbstract;
use App\Engine\SiteAnatomy;

class MetaTag extends WordPressAbstract {


	public $wordPressRegexes = [
		'/WordPress/u',
	];


	public function check( SiteAnatomy $siteAnatomy ) {

		foreach ( $siteAnatomy->metas['generator'] as $metatag ) {
			if ( preg_match( '/WordPress/u', $metatag ) ) {

				$this->setScore( '10', "Detected in meta description" );

			}
		};


		return $this;
	}

	// Check for powered by wordpress
	// Check also for presence of plugins in meta tags to confirm WP

}