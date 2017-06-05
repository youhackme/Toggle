<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;
use Illuminate\Http\Request;
use File;
use Storage;

class ThemeController extends Controller
{
    /**
     * @var ThemeRepository
     */
    protected $theme;

    /**
     * @var ThemeMetaRepository
     */
    protected $themeMeta;

    /**
     * ThemeController constructor.
     *
     * @param $theme
     * @param $themeMeta
     */
    public function __construct(ThemeRepository $theme, ThemeMetaRepository $themeMeta)
    {
        $this->theme     = $theme;
        $this->themeMeta = $themeMeta;
    }


    /**
     * Save theme
     *
     * @param Request $request
     */
    public function add(Request $request)
    {


        $this->validate($request, [
            'uniqueidentifier' => 'required',
            'name'             => 'required',
            'screenshoturl'    => 'required',
            'downloadlink'     => 'required',
            'description'      => 'required',
            'previewlink'      => 'required',
            'provider'         => 'required',
            'type'             => 'required',
        ]);

        if (isset($errors)) {

            echo json_encode($errors);
        }

        $screenshotUrl = $request->input('screenshoturl');


        $result = $this->theme->save([
            'uniqueidentifier' => $request->input('uniqueidentifier'),
            'name'             => $request->input('name'),
            'screenshoturl'    => $screenshotUrl,
            'downloadlink'     => $request->input('downloadlink'),
            'description'      => $request->input('description'),
            'previewlink'      => $request->input('previewlink'),
            'provider'         => $request->input('provider'),
            'type'             => $request->input('type'),
            'status'           => 'detected',
        ]);

        if ($result) {
            $screenshotFileName = $request->input('slug') . '_' . $request->input('screenshotHash');
            $status             = $this->themeMeta->save([
                'themeid'               => $result->id,
                'slug'                  => $request->input('slug'),
                'screenshotExternalUrl' => $screenshotFileName,
                'screenshotHash'        => $request->input('screenshotHash'),
                'status'                => 'active',
            ]);


            $this->saveScreenshotToFileSystem($screenshotFileName, $screenshotUrl);

            echo json_encode($status);
        } else {

            return \Response::json([
                'error' => ['Could not save theme. Already exist'],
            ], 422);


        }
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
    private function saveScreenshotToFileSystem($fileName, $screenshotUrl)
    {
        $goutteClient = \App::make('goutte');
        $goutteClient->request('GET', $screenshotUrl);

        $fileName    = strtolower($fileName) . '.png';
        $imageBinary = $goutteClient->getResponse()->getContent();

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filePath    = $storagePath . $fileName;

        if ( ! File::exists($filePath)) {
            if (Storage::put($fileName, $imageBinary)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

}
