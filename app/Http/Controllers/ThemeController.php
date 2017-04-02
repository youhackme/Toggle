<?php

namespace App\Http\Controllers;


class ThemeController extends Controller {

	public function scrapeThemeForest( $page = 1 ) {
		$pages = explode( '-', $page );

		foreach ( $pages as $page ) {

			$result = ( new \App\Scrape\Themeforest\Theme() )->scrape( $page );

		}

	}

	public function scrapeWordPress() {
		$result = ( new \App\Scrape\WordPress\Theme() )->scrape();

	}


}
