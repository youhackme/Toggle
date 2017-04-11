<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapePlugin extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scrape:plugin  {--page=1-2} {--provider=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scrape TF plugins';

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
		$page     = $this->option( 'page' );

		$this->info( "Scraping plugins from $provider" );
		$methodName = 'scrape' . ucfirst( $provider );


		( new \App\Http\Controllers\PluginController() )->$methodName( $page );

	}
}
