<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 07/04/2017
 * Time: 21:02
 */

namespace App\Engine\WordPress;

use App\Engine\SiteAnatomy;

/**
 * The contract for the detection algorithm (Chain of Responsability design patterns)
 * Class WordPressDetector
 * @package App\Engine\WordPress
 */
abstract class WordPressAbstract {

	/**
	 * Hold the successor in the chain
	 * @var
	 */
	protected $successor;


	/**
	 * Check if it statisfies the algo condition
	 *
	 * @param SiteAnatomy $siteAnatomy
	 *
	 * @return mixed
	 */
	public abstract function check( SiteAnatomy $siteAnatomy );

	/**
	 * Set the successor in the chain
	 *
	 * @param WordPressAbstract $successor
	 */
	public function succeedWith( WordPressAbstract $successor ) {
		$this->successor = $successor;
	}


	/**
	 * Move to check the next successor in the chain
	 *
	 * @param SiteAnatomy $siteAnatomy
	 */
	public function next( SiteAnatomy $siteAnatomy ) {
		if ( $this->successor ) {
			$this->successor->check( $siteAnatomy );
		}
	}
}