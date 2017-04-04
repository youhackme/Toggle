<?php

namespace App\Http\Controllers;


class PluginController extends Controller {


	public function scrapeThemeForest( $page = 1 ) {

		$pages = explode( '-', $page );

		foreach ( range( $pages[0], $pages[1] ) as $page ) {

			( new \App\Scrape\Themeforest\Plugin() )->scrape( $page );

		}
	}

	public function scrapeWordPress() {
		( new \App\Scrape\WordPress\Plugin() )->scrape();

	}
}
