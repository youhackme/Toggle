<?php

namespace App\Console\Commands;

use App\Repositories\Theme\ThemeRepository;
use Illuminate\Console\Command;

class ScrapeTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:theme  {--page=1-2} {--provider=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape TF themes';

    /**
     * An instance of ThemeRepository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ThemeRepository $theme)
    {
        parent::__construct();
        $this->theme = $theme;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $provider = $this->option('provider');
        $page     = $this->option('page');

        $this->info("Scraping plugins from $provider");


        (new \App\Http\Controllers\ThemeController($this->theme))->scrapeTheme($page, $provider);

    }
}
