<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 21:02
 */

namespace App\Engine\WordPress;


abstract class WordPressDetector {
	protected $successor;

	public abstract function check( Engine $engine );

	public function succeedWith( WordPressDetector $successor ) {
		$this->successor = $successor;
	}

	public function next( Engine $engine ) {
		if ( $this->successor ) {
			$this->successor->check( $engine );
		}
	}
}