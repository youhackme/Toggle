<?php

namespace App\Engine;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 10:52
 */
class Engine {


	/**
	 * @var \Symfony\Component\DomCrawler\Crawler
	 */
	private $crawler;


	public function __construct( $site ) {

		$guzzleClient       = new GuzzleClient( [
			'timeout' => 60,
			'headers' => [
				'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',

			],
		] );
		$this->goutteClient = new Client();
		$this->goutteClient->setClient( $guzzleClient );

		$siteToCrawl = "http://" . $site;

		$this->crawler = $this->goutteClient->request(
			'GET',
			$siteToCrawl
		);


	}


	/**
	 * Get the raw HTML
	 * @return null|object
	 */
	public function getHtml() {
		return $this->goutteClient->getResponse()->getContent();
	}

	/**
	 * Get meta tags
	 * @return array
	 */
	public function metatags() {

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
	public function getHeaders() {
		return $this->goutteClient->getResponse()->getHeaders();
	}


	/**
	 * Get HTTP Response code
	 * @return mixed
	 */
	public function getStatus() {
		return $this->goutteClient->getResponse()->getStatus();
	}

	/**
	 * Get cookie jar
	 * @return \Symfony\Component\BrowserKit\CookieJar
	 */
	public function getCookies() {
		return $this->goutteClient->getCookieJar();
	}


	/**
	 * List CSS Sheets
	 * @return array
	 */
	public function getStyleSheets() {
		$styleSheets = [];
		$this->crawler->filterXpath( '//link[@rel="stylesheet"]' )
		              ->each( function ( $styleSheet ) use ( &$styleSheets ) {

			              $styleSheets[] = $styleSheet->attr( 'href' );

		              } );

		return $styleSheets;
	}

	/**
	 * List JS scripts
	 * @return array
	 */
	public function getScripts() {
		$scripts = [];
		$this->crawler->filterXpath( '//script' )
		              ->each( function ( $script ) use ( &$scripts ) {
			              if ( ! is_null( $script->attr( 'src' ) ) ) {
				              $scripts[] = $script->attr( 'src' );
			              }
		              } );

		return $scripts;
	}

	/**
	 * Parse HTML Comments
	 * @return array
	 */
	public function getHtmlComments() {

		$comments = [];
		$this->crawler->filterXpath( '//comment()' )
		              ->each( function ( $comment ) use ( &$comments ) {

			              $comments[] = trim( $comment->text() );

		              } );

		return $comments;

	}


	public function result() {
		return [
			'styles'   => $this->getStyleSheets(),
			'scripts'  => $this->getScripts(),
			'metas'    => $this->metatags(),
			'headers'  => $this->getHeaders(),
			'cookies'  => $this->getCookies(),
			'comments' => $this->getHtmlComments(),
			'status'   => $this->getStatus(),

		];
	}

}