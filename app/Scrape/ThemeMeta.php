<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 30/04/2017
 * Time: 13:34.
 */

namespace App\Scrape;

use App\Repositories\Theme\PluginMetaRepository;
use App\Repositories\Theme\ThemeRepository;
use Bugsnag\Report;
use File;
use Storage;

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

    public function __construct(ThemeRepository $theme, PluginMetaRepository $themeMeta)
    {
        $this->theme     = $theme;
        $this->themeMeta = $themeMeta;
    }

    public function themeforest()
    {
        $this->theme->chunk(10, function ($themes) {
            foreach ($themes as $theme) {

                echo 'Author url: ' . $theme->previewlink . br();

                $data['themeid'] = $theme->id;

                $siteAnatomy = (new \App\Engine\SiteAnatomy($theme->previewlink));

                if ( ! $siteAnatomy->errors()) {
                    $application = (new \App\Engine\WordPress\WordPress($siteAnatomy));

                    if ($application->isWordPress()) {
                        $result = \GuzzleHttp\json_decode($application->details());

                        if ($result->theme) {

                            foreach ($result->theme as $slug => $themeDetail) {
                                if (isset($themeDetail->screenshot->hash)) {

                                    echo $data['slug'] = $slug . br();

                                    $fileName                      = $slug . '_' . $themeDetail->screenshot->hash;
                                    $data['screenshotExternalUrl'] = $fileName;
                                    $data['screenshotHash']        = $themeDetail->screenshot->hash;
                                    if ($this->saveScreenshotToFileSystem($fileName, $this->screenshotExternalUrl)) {
                                        $this->theme->update($data['themeid'], ['status' => 'detected']);
                                        $this->themeMeta->save($data);
                                        echo "Theme alias, screenshot and hash added successfully" . br();
                                    }


                                } else {
                                    echo 'Screenshot path could not be detected.' . br();
                                }
                            }
                        } else {
                            echo "Could not detect theme alias" . br();
                        }
                    } else {
                        echo 'Sadly, you are not using WordPress' . br();
                    }
                    echo br();
                }
            }
        });
    }

    /**
     * @TODO: This function has been duplicted for ease of use. To be refactored.
     * Save Theme screenshot to FileSystem.
     *
     * @param string $fileName      The file name
     * @param        $screenshotUrl The screenshot url
     *
     * @return bool
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
            if (Storage::put($fileName, $imageBinary)) {
                echo "Screenshot $fileName saved successfully";

                return true;
            } else {
                echo 'Could not save screenshot:' . $fileName;

                return false;
            }
        } else {
            echo 'Screenshot already exist';
            \Bugsnag::notifyError('Anomaly', 'Screenshot already exist',
                function (Report $report) use ($fileName) {
                    $report->setSeverity('info');
                    $report->setMetaData([
                        'filename' => $fileName,
                        'other'    => json_encode($this),
                    ]);
                });
        }

        return false;
    }
}
