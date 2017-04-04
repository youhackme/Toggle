<?php

namespace App\Http\Controllers;


class ThemeController extends Controller {

	public function scrapeThemeForest( $page = 1 ) {
		$pages = explode( '-', $page );

		foreach ( range( $pages[0], $pages[1] ) as $page ) {

			( new \App\Scrape\Themeforest\Theme() )->scrape( $page );

		}

	}

	public function scrapeWordPress() {
		 ( new \App\Scrape\WordPress\Theme() )->scrape();

	}


}
