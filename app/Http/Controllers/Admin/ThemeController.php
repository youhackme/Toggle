<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Theme\ThemeRepository;
use App\Repositories\Theme\ThemeMetaRepository;
use Illuminate\Http\Request;

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
     */
    public function add(Request $request)
    {

        $result = $this->theme->save([
            'uniqueidentifier' => $request->input('uniqueidentifier'),
            'name'             => $request->input('name'),
            'screenshoturl'    => $request->input('screenshoturl'),
            'downloadlink'     => $request->input('downloadlink'),
            'description'      => $request->input('description'),
            'previewlink'      => $request->input('previewlink'),
            'provider'         => $request->input('provider'),
            'type'             => $request->input('type'),
            'status'           => 'detected',
        ]);

        if ($result) {
            $status = $this->themeMeta->save([
                'themeid'               => $result->id,
                'slug'                  => $request->input('slug'),
                'screenshotExternalUrl' => $request->input('slug') . '_' . $request->input('screenshotHash'),
                'screenshotHash'        => $request->input('screenshotHash'),
                'status'                => 'active',
            ]);
            echo json_encode($status);
        } else {
            echo json_encode(['error' => 'Could not save theme']);
        }
    }
}
