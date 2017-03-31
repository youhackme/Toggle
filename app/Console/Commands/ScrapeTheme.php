<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeTheme extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scrape:theme  {page=1} {--provider=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scrape TF themes';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {

		$provider = $this->option( 'provider' );
		$page     = $this->argument( 'page' );
		$this->info( "Scraping theme from $provider" );
		$themes = ( new \App\Http\Controllers\ScrapeController() )->result( $page );
		foreach ( $themes as $theme ) {
			$this->info( "Scraped theme {$theme['name']}" );
		}


	}
}
