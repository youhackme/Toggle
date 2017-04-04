<?php

namespace App\Scrape\WordPress;


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
			'http://themes.svn.wordpress.org/'
		);


		$this->client  = $goutteClient;
		$this->crawler = $crawler;


		$theme = [];

		// The Theme name
		$crawler->filter( 'li' )
		        ->each( function ( $themeName ) use ( &$theme ) {
			        $theme['name'] = $themeName->text();

			        $theme['uniqueidentifier'] = $theme['name'];
			        $url           = 'https://wordpress.org/themes/' . $theme['name'];


			        $crawlerThemefullPage = $this->client->request(
				        'GET',
				        $url
			        );

			        $responseStatus = $this->client->getResponse()->getStatus();
			        if ( $responseStatus == 200 ) {

				        $theme['url']      = $url;
				        $theme['provider'] = 'wordpress.org';
				        $theme['type']     = 'free';

				        // Get the Preview URL
				        $crawlerThemefullPage->filter( '.theme-wrap' )
				                             ->each( function ( $content ) use ( & $theme ) {


					                             // Get the Theme name
					                             $content->filter( '.theme-name' )
					                                     ->each( function ( $content ) use ( & $theme ) {
						                                     $theme['name']             = trim( $content->text() );

					                                     } );


					                             // Get the description
					                             $content->filter( '.theme-description' )
					                                     ->each( function ( $content ) use ( & $theme ) {
						                                     $theme['description'] = trim( $content->text() );
					                                     } );

					                             $tags = [];
					                             // Get the description
					                             $content->filter( '.theme-tags a' )
					                                     ->each( function ( $content ) use ( & $theme, &$tags ) {
						                                     $tags[] = $content->text();

					                                     } );
					                             $theme['category'] = substr( implode( ',', $tags ), 0, 150 );


				                             } );


				        if ( $this->exist( trim( $theme['uniqueidentifier'] ) ) ) {
					        $themeModel                   = new ThemeModel;
					        $themeModel->uniqueidentifier = trim( $theme['uniqueidentifier'] );
					        $themeModel->name             = trim( $theme['name'] );
					        $themeModel->url              = trim( $theme['url'] );
					        $themeModel->description      = trim( $theme['description'] );
					        $themeModel->provider         = $theme['provider'];
					        $themeModel->category         = trim( $theme['category'] );
					        $themeModel->type             = $theme['type'];
					        $themeModel->save();

				        }


			        } else {
				        echo "Theme {$theme['name']} does not exist";
				        echo br();
			        }


		        } );
	}


	public function exist( $externalThemeIdentifier ) {


		if ( ! ThemeModel::where( 'uniqueidentifier', '=', $externalThemeIdentifier )->exists() ) {
			echo "[" . getMemUsage() . "]$externalThemeIdentifier is a new Theme.";
			echo br();

			return true;
		} else {
			echo "[" . getMemUsage() . "]$externalThemeIdentifier has already been scrapped.";
			echo br();

			return false;
		}

	}


}