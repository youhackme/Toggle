<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EngineController extends Controller {


	public function detect($site) {
		$result = ( new \App\Engine\Engine($site) )->result();
		dd($result);
	}
}
