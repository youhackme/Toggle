<?php

namespace App\Engine;

use App;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 10:52
 */
class SiteAnatomy {


	/**
	 * @var \Symfony\Component\DomCrawler\Crawler
	 */
	private $crawler;
	public $styles;
	public $scripts;
	public $metas;
	public $headers;
	public $cookies;
	public $comments;
	public $status;
	public $css;
	public $innerlinks;


	public function __construct( $site ) {

		$this->goutteClient = App::make( 'goutte' );

		$this->crawler = $this->goutteClient->request(
			'GET',
			"http://" . $site
		);

		$this->result();

	}


	/**
	 * Get the raw HTML
	 * @return null|object
	 */
	private function getHtml() {
		return $this->goutteClient->getResponse()->getContent();
	}

	/**
	 * Get meta tags
	 * @return array
	 */
	private function metatags() {

		$tags = [];
		$this->crawler->filterXpath( '//meta[@name="generator"]' )
		              ->each( function ( $metaTags ) use ( &$tags ) {

			              $tags['generator'][] = $metaTags->attr( 'content' );

		              } );

		return $tags;

	}

	/**
	 * Get HTTP Headers
	 * @return mixed
	 */
	private function getHeaders() {
		return $this->goutteClient->getResponse()->getHeaders();
	}


	/**
	 * Get HTTP Response code
	 * @return mixed
	 */
	private function getStatus() {
		return $this->goutteClient->getResponse()->getStatus();
	}

	/**
	 * Get cookie jar
	 * @return \Symfony\Component\BrowserKit\CookieJar
	 */
	private function getCookies() {
		return $this->goutteClient->getCookieJar();
	}


	/**
	 * List CSS Sheets
	 * @return array
	 */
	private function getStyleSheets() {
		$styleSheets = [];
		$this->crawler->filterXpath( '//link[@rel="stylesheet"]' )
		              ->each( function ( $styleSheet ) use ( &$styleSheets ) {

			              $styleSheets[] = $styleSheet->attr( 'href' );

		              } );

		return array_unique( $styleSheets );
	}

	/**
	 * List JS scripts
	 * @return array
	 */
	private function getScripts() {
		$scripts = [];
		$this->crawler->filterXpath( '//script' )
		              ->each( function ( $script ) use ( &$scripts ) {
			              if ( ! is_null( $script->attr( 'src' ) ) ) {
				              $scripts[] = $script->attr( 'src' );
			              }
		              } );

		return array_unique( $scripts );
	}

	/**
	 * Parse HTML Comments
	 * @return array
	 */
	private function getHtmlComments() {

		$comments = [];
		$this->crawler->filterXpath( '//comment()' )
		              ->each( function ( $comment ) use ( &$comments ) {

			              $comments[] = trim( $comment->text() );

		              } );

		return $comments;

	}


	/**
	 * Extract CSS Class names
	 * @return array
	 */
	private function getCssClasses() {

		$cssClasses = [];
		$this->crawler->filterXpath( '//*[@class]' )
		              ->each( function ( $cssClass ) use ( &$cssClasses ) {

			              $classes      = trim( $cssClass->attr( 'class' ) );
			              $classes      = explode( ' ', $classes );
			              $cssClasses[] = $classes;

		              } );

		$uniqueCssClasses = array_unique( array_flatten( $cssClasses ) );

		$finalCssClasses = [];
		foreach ( $uniqueCssClasses as $uniqueCssClass ) {
			if ( strlen( $uniqueCssClass ) > 5 ) {
				$finalCssClasses[] = $uniqueCssClass;
			}
		}


		return $finalCssClasses;

	}

	/**
	 * Extract CSS Ids
	 * @return array
	 */
	private function getCssIds() {

		$cssIds = [];
		$this->crawler->filterXpath( '//*[@id]' )
		              ->each( function ( $cssId ) use ( &$cssIds ) {

			              $cssIds[] = trim( $cssId->attr( 'id' ) );

		              } );

		$uniqueCssIds = array_unique( array_flatten( $cssIds ) );

		$finalCssIds = [];
		foreach ( $uniqueCssIds as $uniqueCssId ) {
			if ( strlen( $uniqueCssId ) > 5 ) {
				$finalCssIds[] = $uniqueCssId;
			}
		}

		return $finalCssIds;
	}

	/**
	 * Find inner links of a domain to make further analysis
	 */
	private function getInnnerLinks() {

	}


	/**
	 * Get the result
	 * @return array
	 */
	private function result() {

		$this->styles     = $this->getStyleSheets();
		$this->scripts    = $this->getScripts();
		$this->metas      = $this->metatags();
		$this->headers    = $this->getHeaders();
		$this->cookies    = $this->getCookies();
		$this->comments   = $this->getHtmlComments();
		$this->status     = $this->getStatus();
		$this->css        = [
			'classes' => $this->getCssClasses(),
			'ids'     => $this->getCssIds(),
		];
		$this->innerlinks = $this->getInnnerLinks();

	}

}