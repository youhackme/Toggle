<?php

namespace App\Http\Controllers;


class ThemeController extends Controller {

	public function scrapeThemeForest( $page = 1 ) {
		$result = ( new \App\Scrape\Themeforest\Theme() )->scrape( $page );
		return $result;
	}

	public function scrapeWordPress() {
		$result = ( new \App\Scrape\WordPress\Theme() )->scrape();
		return $result;
	}


}
