<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */

namespace App\Scrape\Themeforest;



use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


/**
 * Scrape plugins from Themeforest
 * @package App\Scrape\Themeforest
 */
class Plugin {


	private $result;
	private $crawler;
	private $client;

	public function scrape( $page = 1 ) {


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
			'https://codecanyon.net/category/wordpress?page=' . $page
		);


		$this->client  = $goutteClient;
		$this->crawler = $crawler;


		$plugin = [];


		$crawler->filter( 'li.js-google-analytics__list-event-container' )->each( function ( $themelist ) use ( &$plugin
		) {


			// The theme Unique id
			$plugin['id'] = $themelist->attr( 'data-item-id' );

			// The theme name
			$themelist->filter( 'h3' )->each( function ( $themeTitle ) use ( &$plugin
			) {
				$plugin['name'] = $themeTitle->text();

			} );

			// The theme preview  screenshot
			$themelist->filter( 'img.preload' )->each( function ( $themeImage ) use ( &$plugin
			) {
				$plugin['previewScreenshot'] = $themeImage->attr( 'data-preview-url' );
			} );

			// The theme preview  screenshot
			$themelist->filter( '[itemprop="genre"]' )->each( function ( $themeImage ) use ( &$plugin
			) {
				$plugin['category'] = $themeImage->text();
			} );


			// Click on each theme name and go to their theme page details
			if ( ! empty( trim( $plugin['name'] ) ) ) {

				try {
					$link                 = $this->crawler->selectLink( trim( $plugin['name'] ) )->link();
					$crawlerThemefullPage = $this->client->click( $link );


					// Get the Preview URL
					$crawlerThemefullPage->filter( 'a.live-preview' )->each( function ( $themePreviewlink ) use (
						&
						$plugin
					) {
						$plugin['previewURL'] = $themePreviewlink->attr( 'href' );
					} );


					// Get the theme description
					$crawlerThemefullPage->filter( 'div.item-description' )->each( function ( $themeDescription ) use (
						&$plugin
					) {
						$plugin['description'] = $themeDescription->text();
					} );

					// Click on the preview link
					$previewlink             = $crawlerThemefullPage->selectLink( 'Live Preview' )->link();
					$crawlerThemePreviewLink = $this->client->click( $previewlink );

					// Get the theme url hosted by the author
					$crawlerThemePreviewLink->filter( 'div.preview__action--close a' )->each( function (
						$themeDescription
					) use ( &$plugin
					) {
						$plugin['origin'] = $themeDescription->attr( 'href' );
					} );


					/*$crawler->filter('tbody > tr > td > a')->each(function ($node, $i = 0) use (&$URLs)
					{
						{
							$URLs[] = $node->attr('href');
						}
					});*/


					$this->result[] = [
						'id'                => trim( $plugin['id'] ),
						'name'              => trim( $plugin['name'] ),
						'previewScreenshot' => trim( $plugin['previewScreenshot'] ),
						'previewURL'        => trim( $plugin['previewURL'] ),
						'description'       => trim( $plugin['description'] ),
						'origin'            => trim( $plugin['origin'] ),
						'category'          => trim( $plugin['category'] ),
					];


				} catch ( \InvalidArgumentException $e ) {
					echo "Well, it sucks. Cannot scrape: " . json_encode( $plugin['id'] );
				}
			} else {
				echo "No data for" . $plugin['id'];
			}

		} );

		dd( $this->result );


		return $this->result;


	}


}