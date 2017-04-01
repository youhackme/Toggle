<?php

namespace App\Http\Controllers;


class PluginController extends Controller {


	public function scrapeThemeForest( $page = 1 ) {
		$result = ( new \App\Scrape\Themeforest\Plugin() )->scrape( $page );

		return $result;

	}

	public function scrapeWordPress() {
		$result = ( new \App\Scrape\WordPress\Plugin() )->scrape();

		return $result;
	}
}
