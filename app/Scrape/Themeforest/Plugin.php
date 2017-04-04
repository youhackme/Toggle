<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 01/04/2017
 * Time: 11:26
 */

namespace App\Scrape\Themeforest;


use App\Plugin as PluginModel;


/**
 * Scrape plugins from Themeforest
 * @package App\Scrape\Themeforest
 */
class Plugin {



	private $crawler;
	private $goutteClient;

	public function scrape( $page = 1 ) {


		$pageToCrawl = 'https://codecanyon.net/category/wordpress?page=' . $page;
		echo "Scraping page: $pageToCrawl";
		echo br();

		$this->goutteClient = \App::make( 'goutte' );

		$this->crawler = $this->goutteClient->request(
			'GET',
			$pageToCrawl
		);


		$plugin = [];


		$this->crawler->filter( 'li.js-google-analytics__list-event-container' )
		              ->each( function ( $themelist ) use ( &$plugin ) {


			              // The theme Unique id
			              $plugin['id'] = $themelist->attr( 'data-item-id' );

			              // The theme name
			              $themelist->filter( 'h3' )
			                        ->each( function ( $themeTitle ) use ( &$plugin ) {
				                        $plugin['name'] = $themeTitle->text();
			                        } );

			              // The theme preview  screenshot
			              $themelist->filter( 'img.preload' )
			                        ->each( function ( $themeImage ) use ( &$plugin ) {
				                        $plugin['previewScreenshot'] = $themeImage->attr( 'data-preview-url' );
			                        } );

			              // The theme preview  screenshot
			              $themelist->filter( '[itemprop="genre"]' )
			                        ->each( function ( $themeImage ) use ( &$plugin ) {
				                        $plugin['category'] = $themeImage->text();
			                        } );


			              // Click on each theme name and go to their theme page details
			              if ( ! empty( trim( $plugin['name'] ) ) ) {

				              try {
					              $link                       = $this->crawler->selectLink( trim( $plugin['name'] ) )->link();
					              $this->crawlerThemefullPage = $this->goutteClient->click( $link );


					              // Get the Preview URL
					              $this->crawlerThemefullPage->filter( 'a.live-preview' )
					                                         ->each( function ( $themePreviewlink ) use ( & $plugin ) {
						                                         $plugin['previewURL'] = $themePreviewlink->attr( 'href' );
					                                         } );


					              // Get the theme description
					              $this->crawlerThemefullPage->filter( 'div.item-description' )
					                                         ->each( function ( $themeDescription ) use ( &$plugin ) {
						                                         $plugin['description'] = $themeDescription->text();
					                                         } );

					              // Click on the preview link
					              $previewlink                   = $this->crawlerThemefullPage->selectLink( 'Live Preview' )->link();
					              $this->crawlerThemePreviewLink = $this->goutteClient->click( $previewlink );

					              // Get the theme url hosted by the author
					              $this->crawlerThemePreviewLink->filter( 'div.preview__action--close a' )
					                                            ->each( function ( $themeDescription ) use ( &$plugin
					                                            ) {
						                                            $plugin['origin'] = $themeDescription->attr( 'href' );
					                                            } );


					              if ( $this->exist( trim( $plugin['id'] ) ) ) {
						              $pluginModel                   = new PluginModel;
						              $pluginModel->uniqueidentifier = trim( $plugin['id'] );
						              $pluginModel->name             = trim( $plugin['name'] );
						              $pluginModel->url              = trim( $plugin['previewURL'] );
						              $pluginModel->downloadlink     = trim( $plugin['previewURL'] );
						              $pluginModel->demolink         = trim( $plugin['origin'] );
						              $pluginModel->description      = trim( $plugin['description'] );
						              $pluginModel->screenshotUrl    = trim( $plugin['previewScreenshot'] );
						              $pluginModel->provider         = 'themeforest';
						              $pluginModel->category         = trim( $plugin['category'] );
						              $pluginModel->type             = 'premium';
						              $pluginModel->save();
					              }




				              } catch ( \InvalidArgumentException $e ) {
					              echo "Well, it sucks. Cannot scrape: " . json_encode( $plugin['id'] );
					              echo "<br/> \n";
				              }
			              } else {
				              echo "No data for" . $plugin['id'];
				              echo "<br/> \n";
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