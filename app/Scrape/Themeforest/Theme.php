<?php

namespace App\Scrape\Themeforest;


use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\Theme as ThemeModel;


/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */
class Theme {

	/**
	 * Store theme meta data
	 * @var array
	 */
	private $data;
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

		$pageToCrawl = 'https://themeforest.net/category/wordpress?page=' . $page . '&utf8=%E2%9C%93&referrer=search&view=list&sort=sales';
		echo "Scraping page: $pageToCrawl";
		echo br();

		$crawler = $goutteClient->request(
			'GET',
			$pageToCrawl
		);




		$this->client  = $goutteClient;
		$this->crawler = $crawler;

		$theme = [];

		$crawler->filter( 'li.js-google-analytics__list-event-container' )->each( function ( $themelist ) use ( &$theme
		) {

			// The theme Unique id
			$theme['id'] = $themelist->attr( 'data-item-id' );

			// The theme name
			$themelist->filter( 'h3' )->each( function ( $themeTitle ) use ( &$theme ) {
				$theme['name'] = $themeTitle->text();

			} );


			// The theme preview  screenshot
			$themelist->filter( 'img.preload' )->each( function ( $themeImage ) use ( &$theme ) {
				$theme['previewScreenshot'] = $themeImage->attr( 'data-preview-url' );
			} );


			// Click on each theme name and go to their theme page details
			if ( ! empty( trim( $theme['name'] ) ) ) {

				try {
					$link                 = $this->crawler->selectLink( trim( $theme['name'] ) )->link();
					$crawlerThemefullPage = $this->client->click( $link );


					// Get the Preview URL
					$crawlerThemefullPage->filter( 'a.live-preview' )->each( function ( $themePreviewlink ) use (
						&
						$theme
					) {
						$theme['previewURL'] = $themePreviewlink->attr( 'href' );
					} );


					// Get the theme description
					$crawlerThemefullPage->filter( 'div.item-description' )->each( function ( $themeDescription ) use (
						&$theme
					) {
						$theme['description'] = $themeDescription->text();
					} );

					// Click on the preview link
					$previewlink             = $crawlerThemefullPage->selectLink( 'Live Preview' )->link();
					$crawlerThemePreviewLink = $this->client->click( $previewlink );

					// Get the theme url hosted by the author
					$crawlerThemePreviewLink->filter( 'div.preview__action--close a' )->each( function (
						$themeDescription
					) use (
						&$theme
					) {
						$theme['origin'] = $themeDescription->attr( 'href' );
					} );


					if ( $this->exist( trim( $theme['id'] ) ) ) {
						$themeModel                   = new ThemeModel;
						$themeModel->uniqueidentifier = trim( $theme['id'] );
						$themeModel->name             = trim( $theme['name'] );
						$themeModel->url              = trim( $theme['previewURL'] );
						$themeModel->downloadLink     = trim( $theme['previewURL'] );
						$themeModel->PreviewLink      = trim( $theme['origin'] );
						$themeModel->description      = trim( $theme['description'] );
						$themeModel->screenshotUrl    = trim( $theme['previewScreenshot'] );
						$themeModel->provider         = 'themeforest';
						$themeModel->type             = 'premium';
						$themeModel->save();
					}


					$this->data[] = [
						'id'                => trim( $theme['id'] ),
						'name'              => trim( $theme['name'] ),
						'previewScreenshot' => trim( $theme['previewScreenshot'] ),
						'previewURL'        => trim( $theme['previewURL'] ),
						'description'       => trim( $theme['description'] ),
						'origin'            => trim( $theme['origin'] ),
					];
				} catch ( \InvalidArgumentException $e ) {
					echo "Well, it sucks. Cannot scrape: " . json_encode( $theme['id'] );
				}
			} else {
				echo "No data for" . $theme['id'];
			}

		} );


		return $this->data;


	}


	public function exist( $externalThemeIdentifier ) {


		if ( ! ThemeModel::where( 'uniqueidentifier', '=', $externalThemeIdentifier )->exists() ) {
			echo "[" . getMemUsage() . "]$externalThemeIdentifier is a new theme.";
			echo br();

			return true;
		} else {
			echo "[" . getMemUsage() . "]$externalThemeIdentifier has already been scrapped.";
			echo br();

			return false;
		}

	}

}