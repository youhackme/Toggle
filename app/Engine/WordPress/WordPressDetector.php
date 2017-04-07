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

	public abstract function check( WordPress $wordpress );

	public function succeedWith( WordPressDetector $successor ) {
		$this->successor = $successor;
	}

	public function next( WordPress $wordpress ) {
		if ( $this->successor ) {
			$this->successor->check( $wordpress );
		}
	}
}