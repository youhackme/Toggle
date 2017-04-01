<?php

namespace App\Scrape\WordPress;

use Illuminate\Http\Request;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */
class Plugin {

	/**
	 * Store theme meta data
	 * @var array
	 */
	private $plugin = [];
	private $result;
	private $crawler;
	private $client;

	/**
	 * Scrape WordPress.org
	 */
	public function scrape() {
		$guzzleClient = new GuzzleClient( [
			'timeout' => 60,
			'headers' => [
				'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',

			],
		] );
		$goutteClient = new Client();
		$goutteClient->setClient( $guzzleClient );


		$crawler = $goutteClient->request(
			'GET',
			'http://plugins.svn.wordpress.org/'
		);


		$this->client  = $goutteClient;
		$this->crawler = $crawler;


		$plugin = [];

		// The plugin name
		$crawler->filter( 'li' )->each( function ( $pluginName ) use ( &$plugin
		) {
			$plugin['name'] = $pluginName->text();
			echo '<a href="https://wordpress.org/plugins/' . $plugin['name'] . '">' . $plugin['name'] . '</a>';
			echo "<br/>";

		} );
	}

}