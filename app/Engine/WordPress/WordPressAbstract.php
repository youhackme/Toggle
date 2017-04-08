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
	 * Score
	 * @var
	 */
	public $score;


	/**
	 * Check if it statisfies the algo condition
	 *
	 * @param SiteAnatomy $siteAnatomy
	 *
	 * @return mixed
	 */
	public abstract function check( SiteAnatomy $siteAnatomy );


	/**
	 * Set score if detected to measure accuracy
	 *
	 * @param $score
	 * @param $description
	 */
	public function setScore( $score, $description ) {
		$this->score = [
			'score'       => $score,
			'description' => $description,
		];
	}

	/**
	 * Get Score
	 * @return mixed
	 */
	public function getScore() {
		return $this->score;
	}


}