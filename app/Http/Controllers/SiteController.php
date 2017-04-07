<?php

namespace App\Http\Controllers;



class SiteController extends Controller {


	public function detect($site) {
		$result = ( new \App\Engine\Site($site) )->result();
		dd($result);
	}
}
