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
	 * Plugin
	 * @var
	 */
	public $plugins;

	public $confidence = 0;


	/**
	 * Check if it statisfies the algo condition
	 *
	 * @param SiteAnatomy $siteAnatomy
	 *
	 * @return mixed
	 */
	public abstract function check( SiteAnatomy $siteAnatomy );


	public function dictionary() {

		return [
			"type" => [
				"plugin" => [
					"W3 Total Cache" => [
						"headers" => [
							"X-Powered-By" => "/W3 Total Cache/u",
						],
						"html"    => [
							"<!--[^>]+W3 Total Cache",
						],
					],
				],
			],
		];

	}


	public function setPlugin( $name, $description ) {
		$this->plugins[] = [
			'name'        => $name,
			'description' => $description,
		];
	}

	/**
	 * Get Score
	 * @return mixed
	 */
	public function getPlugin() {
		return $this->plugins;
	}

	public function getConfidence() {
		return $this->confidence;
	}

	public function setConfidence( $confidence ) {
		$this->confidence = $confidence;
	}


}