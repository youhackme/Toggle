<?php

namespace App\Http\Controllers;


class SiteController extends Controller {


	public function detect( $site ) {

		$siteAnatomy = ( new \App\Engine\SiteAnatomy( $site ) );


		$wordPress = ( new \App\Engine\WordPress\WordPress( $siteAnatomy ) )->detect();

		dd( $wordPress );
	}
}
