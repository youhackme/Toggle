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

class Html extends WordPressAbstract {

	public $siteAnatomy;
	public $isWordpress = false;

	public function check( SiteAnatomy $siteAnatomy ) {
		$this->siteAnatomy = $siteAnatomy;

		$this->checkInMetatags();
		$this->checkUri();

		return $this;

	}


	public function checkInMetatags() {
		if ( isset( $this->siteAnatomy->metas['generator'] ) ) {

			foreach ( $this->siteAnatomy->metas['generator'] as $metatag ) {
				if ( preg_match( '/WordPress/u', $metatag ) ) {
					$this->isWordpress['metagtag'] = true;
					//$this->setConfidence( 90 );
				}
			};
		}
	}

	public function checkUri() {

		if ( preg_match( '/wp-content|wp-includes/i', $this->siteAnatomy->html, $matches ) ) {
			$this->isWordpress['uri'] = true;
		}
	}

}