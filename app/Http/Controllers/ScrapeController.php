<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


class ScrapeController extends Controller {

	/**
	 * Store theme meta data
	 * @var array
	 */
	private $theme = [];
	private $data;
	private $crawler;
	private $client;


	public function __construct() {


	}


	public function result( $page = 1 ) {


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
			'https://themeforest.net/category/wordpress?page=' . $page . '&utf8=%E2%9C%93&referrer=search&view=list'
		);


		$this->client  = $goutteClient;
		$this->crawler = $crawler;


		$crawler->filter( 'li.js-google-analytics__list-event-container' )->each( function ( $themelist ) {

			// The theme Unique id
			$this->theme['id'] = $themelist->attr( 'data-item-id' );

			// The theme name
			$themelist->filter( 'h3' )->each( function ( $themeTitle ) {
				$this->theme['name'] = $themeTitle->text();
			} );


			// The theme preview  screenshot
			$themelist->filter( 'img.preload' )->each( function ( $themeImage ) {
				$this->theme['previewScreenshot'] = $themeImage->attr( 'data-preview-url' );
			} );

			// Click on each theme name and go to their theme page details
			$link                 = $this->crawler->selectLink( $this->theme['name'] )->link();
			$crawlerThemefullPage = $this->client->click( $link );


			// Get the Preview URL
			$crawlerThemefullPage->filter( 'a.live-preview' )->each( function ( $themePreviewlink ) {
				$this->theme['previewURL'] = $themePreviewlink->attr( 'href' );
			} );


			// Get the theme description
			$crawlerThemefullPage->filter( 'div.item-description' )->each( function ( $themeDescription ) {
				$this->theme['description'] = $themeDescription->text();
			} );

			// Click on the preview link
			$previewlink             = $crawlerThemefullPage->selectLink( 'Live Preview' )->link();
			$crawlerThemePreviewLink = $this->client->click( $previewlink );

			// Get the theme url hosted by the author
			$crawlerThemePreviewLink->filter( 'div.preview__action--close a' )->each( function ( $themeDescription ) {
				$this->theme['origin'] = $themeDescription->attr( 'href' );
			} );


			$this->data[] = [
				'id'                => trim( $this->theme['id'] ),
				'name'              => trim( $this->theme['name'] ),
				'previewScreenshot' => trim( $this->theme['previewScreenshot'] ),
				'previewURL'        => trim( $this->theme['previewURL'] ),
				'description'       => trim( $this->theme['description'] ),
				'origin'            => trim( $this->theme['origin'] ),
			];


		} );


		return $this->data;


	}


	public function test() {
		return [
			[
				'Name'  => 'Hyder',
				'Email' => 'ismaakeel@gmail.com',
			],
			[
				'Name'  => 'Hyder',
				'Email' => 'darktips.com@gmail.com',
			],
		];
	}

}
