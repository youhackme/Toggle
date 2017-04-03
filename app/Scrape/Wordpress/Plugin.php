<?php

namespace App\Scrape\WordPress;


use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\Plugin as PluginModel;

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
		$crawler->filter( 'li' )
		        ->each( function ( $pluginName ) use ( &$plugin ) {
			        $plugin['name'] = $pluginName->text();
			        $url            = 'https://wordpress.org/plugins/' . $plugin['name'];
			        echo '<a href="' . $url . '">' . $plugin['name'] . '</a>';
			        echo "<br/>";


			        $crawlerPluginfullPage = $this->client->request(
				        'GET',
				        $url
			        );

			        $plugin['url']      = $url;
			        $plugin['provider'] = 'wordpress.org';
			        $plugin['type']     = 'free';


			        // Get the Preview URL
			        $crawlerPluginfullPage->filter( '#main' )
			                              ->each( function ( $content ) use ( & $plugin ) {


				                              // Get the plugin name
				                              $content->filter( '.plugin-title' )
				                                      ->each( function ( $content ) use ( & $plugin ) {
					                                      $plugin['name']             = trim( $content->text() );
					                                      $plugin['screenshotUrl']    = 'https://ps.w.org/' . $plugin['name'] . '/assets/icon-128x128.png';
					                                      $plugin['uniqueidentifier'] = $plugin['name'];
				                                      } );


				                              // Get the description
				                              $content->filter( '#description' )
				                                      ->each( function ( $content ) use ( & $plugin ) {
					                                      $plugin['description'] = trim( $content->text() );
				                                      } );

				                              $tags = [];
				                              // Get the description
				                              $content->filter( '.tags a' )
				                                      ->each( function ( $content ) use ( & $plugin, $tags ) {
					                                      $tags[] = $content->text();
				                                      } );
				                              $plugin['category'] = implode( ',', $tags );


			                              } );

			        if ( $this->exist( trim( $plugin['uniqueidentifier'] ) ) ) {
				        $pluginModel                   = new PluginModel;
				        $pluginModel->uniqueidentifier = trim( $plugin['uniqueidentifier'] );
				        $pluginModel->name             = trim( $plugin['name'] );
				        $pluginModel->url              = trim( $plugin['url'] );
				        $pluginModel->description      = trim( $plugin['description'] );
				        $pluginModel->screenshotUrl    = trim( $plugin['screenshotUrl'] );
				        $pluginModel->provider         = $plugin['provider'];
				        $pluginModel->category         = trim( $plugin['category'] );
				        $pluginModel->type             = $plugin['type'];
				        $pluginModel->save();

			        }


		        } );
	}


	public function exist( $externalPluginIdentifier ) {


		if ( ! PluginModel::where( 'uniqueidentifier', '=', $externalPluginIdentifier )->exists() ) {
			echo "[" . getMemUsage() . "]$externalPluginIdentifier is a new plugin.";
			echo br();

			return true;
		} else {
			echo "[" . getMemUsage() . "]$externalPluginIdentifier has already been scrapped.";
			echo br();

			return false;
		}

	}


}