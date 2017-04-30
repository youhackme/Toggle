<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 30/04/2017
 * Time: 13:34
 */

namespace App\Scrape;

use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;
use File;
use Storage;

/**
 * Advanced scrapping of theme:
 * 1. find alias name, screenshot and hash
 * 2. Save screenshot to local filesystem
 * 3. Update theme table
 * Class ThemeMeta
 * @package App\ThemeMeta
 */
class ThemeMeta
{
    public $theme;
    public $slug;
    public $screenshotExternalUrl;
    public $screenshotHash;


    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta)
    {
        $this->theme     = $theme;
        $this->themeMeta = $themeMeta;
    }

    public function themeforest()
    {
        $this->theme->chunk(10, function ($themes) {
            foreach ($themes as $theme) {
                $site = $theme->previewlink;
                echo 'Author url: ' . $site;
                echo br();
                $siteAnatomy = (new \App\Engine\SiteAnatomy($site));
                if ( ! $siteAnatomy->errors()) {
                    $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

                    if ($application->isWordPress()) {
                        $result = \GuzzleHttp\json_decode($application->details());
                        foreach ($result->screenshot as $slug => $theme) {
                            echo $slug;
                            echo br();
                            echo $theme->url;
                            $fileName = $slug . '_' . $theme->hash;
                            $this->saveScreenshotToFileSystem($fileName, $this->screenshotExternalUrl);
                            echo br();
                            echo $theme->hash;
                        }

                    } else {
                        echo 'Sadly, you are not using WordPress';
                    }
                    echo br();
                    exit();
                }

            }
        });
    }

    /**
     * Save Theme screenshot to FileSystem
     * @param $fileName The file name
     * @param $screenshotUrl The screenshot url
     */
    public function saveScreenshotToFileSystem($fileName, $screenshotUrl)
    {

        $goutteClient = \App::make('goutte');
        $goutteClient->request('GET', $screenshotUrl);

        $fileName    = strtolower($fileName) . '.png';
        $imageBinary = $goutteClient->getResponse()->getContent();


        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filePath    = $storagePath . $fileName;

        if ( ! File::exists($filePath)) {
            Storage::put($fileName, $imageBinary);
        }

    }

}