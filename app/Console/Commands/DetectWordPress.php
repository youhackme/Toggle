<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;

class DetectWordPress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:ThemeMeta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Theme meta data (screenshot, slug etc.) for existing saved theme';

    /**
     * An instance of Theme Repository.
     *
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * An instance of ThemeMeta.
     * @var ThemeMetaRepository
     */
    protected $themeMeta;

    /**
     * DetectWordPress constructor.
     *
     * @param ThemeRepository     $theme
     * @param ThemeMetaRepository $themeMeta
     */
    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta)
    {
        parent::__construct();
        $this->theme = $theme;
        $this->themeMeta = $themeMeta;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Extracting theme meta data(alias, screenshot etc)');
        (new \App\Http\Controllers\ThemeController($this->theme, $this->themeMeta))->scrapeThemeMeta();
    }
}
