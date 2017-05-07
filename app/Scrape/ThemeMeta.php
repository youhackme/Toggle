<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 30/04/2017
 * Time: 13:34.
 */

namespace App\Scrape;

use File;
use Storage;
use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;

/**
 * Advanced scrapping of theme:
 * 1. find alias name, screenshot and hash
 * 2. Save screenshot to local filesystem
 * 3. Update theme table
 * Class ThemeMeta.
 */
class ThemeMeta
{
    public $theme;
    public $slug;
    public $screenshotExternalUrl;
    public $screenshotHash;

    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta)
    {
        $this->theme = $theme;
        $this->themeMeta = $themeMeta;
    }

    public function themeforest()
    {
        $this->theme->chunk(10, function($themes) {
            foreach ($themes as $theme) {
                $site = $theme->previewlink;
                echo 'Author url: ' . $site;
                echo br();

                $data['themeid'] = $theme->id;

                $siteAnatomy = (new \App\Engine\SiteAnatomy($site));

                if ( ! $siteAnatomy->errors()) {
                    $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

                    if ($application->isWordPress()) {
                        $result = \GuzzleHttp\json_decode($application->details());
                        foreach ($result->screenshot as $slug => $theme) {
                            echo $data['slug'] = $slug;
                            echo br();
                            $fileName = $slug . '_' . $theme->hash;
                            $data['screenshotExternalUrl'] = $fileName;
                            $data['screenshotHash'] = $theme->hash;
                            if ($this->saveScreenshotToFileSystem($fileName, $this->screenshotExternalUrl)) {
                                $this->theme->update($data['themeid'], 'detected');
                                $this->themeMeta->save($data);
                                // Update table theme
                                // Add record to theme Alias
                            }
                            echo br();
                            echo $theme->hash;
                        }
                    } else {
                        echo 'Sadly, you are not using WordPress';
                    }
                    echo br();
                }
            }
        });
    }

    /**
     * Save Theme screenshot to FileSystem.
     *
     * @param string $fileName      The file name
     * @param $screenshotUrl The screenshot url
     *
     * @return bool
     */
    public function saveScreenshotToFileSystem($fileName, $screenshotUrl)
    {
        $goutteClient = \App::make('goutte');
        $goutteClient->request('GET', $screenshotUrl);

        $fileName = strtolower($fileName) . '.png';
        $imageBinary = $goutteClient->getResponse()->getContent();

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filePath = $storagePath . $fileName;

        if ( ! File::exists($filePath)) {
            if (Storage::put($fileName, $imageBinary)) {
                echo "Screenshot $fileName saved successfully";

                return true;
            } else {
                echo 'Could not save screenshot:' . $fileName;

                return false;
            }
        }

        return false;
    }
}
