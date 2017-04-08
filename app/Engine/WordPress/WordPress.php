<?php

namespace App\Engine\WordPress;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 22:16
 */
/**
 * Handle the algorithm to detect if a site is using WordPress
 * @package App\Engine\WordPress
 */
class WordPress {


	public $metaTag = true;
	public $link = true;
	public $robot = true;

	public $siteAnatomy;


	public function __construct( $siteAnatomy ) {

		$this->siteAnatomy = $siteAnatomy;

	}

	public function detect() {

		$metatag = new MetaTag();

		$link    = new Link();
//		$plugin  = new Plugin();
//		$robot   = new Robot();
//		$theme   = new Theme();

		$metatag->succeedWith( $link );
		//$link->succeedWith( $plugin );
		//$plugin->succeedWith( $robot );
		//$robot->succeedWith( $theme );

		$metatag->check( $this->siteAnatomy );
	}


}