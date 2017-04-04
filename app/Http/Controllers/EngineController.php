<?php

namespace App\Http\Controllers;



class EngineController extends Controller {


	public function detect($site) {
		$result = ( new \App\Engine\Engine($site) )->result();
		dd($result);
	}
}
