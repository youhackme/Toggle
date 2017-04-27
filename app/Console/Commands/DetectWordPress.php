<?php

namespace App\Console\Commands;

use App\Repositories\Theme\ThemeRepository;
use Illuminate\Console\Command;

class DetectWordPress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:themealias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'detect theme Alias for existing saved data';

    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * DetectWordPress constructor.
     *
     * @param ThemeRepository $theme
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
        $this->info('Extracting theme Alias');
        (new \App\Http\Controllers\ThemeController($this->theme))->scrapeThemeAlias();
    }
}
