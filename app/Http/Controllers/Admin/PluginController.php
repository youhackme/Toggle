<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Plugin\PluginMetaRepository;
use App\Repositories\Plugin\PluginRepository;
use DB;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    /**
     * @var PluginRepository
     */
    protected $plugin;

    /**
     * @var PluginMetaRepository
     */
    protected $pluginMeta;

    /**
     * PluginController constructor.
     *
     * @param $plugin
     * @param $pluginMeta
     */
    public function __construct(PluginRepository $plugin, PluginMetaRepository $pluginMeta)
    {
        $this->plugin     = $plugin;
        $this->pluginMeta = $pluginMeta;
    }


    /**
     * Save theme
     *
     * @param Request $request
     */
    public function add(Request $request)
    {


        $this->validate($request, [
            'id'               => 'required',
            'uniqueidentifier' => 'required',
            'name'             => 'required',
            'slug'             => 'required',
            'screenshoturl'    => 'required',
            'downloadlink'     => 'required',
            'description'      => 'required',
            'previewlink'      => 'required',
            // 'provider'         => 'required',
            // 'type'             => 'required',
        ]);

        if (isset($errors)) {

            echo json_encode($errors);
        }

        $id = $request->input('id');


        $result = $this->plugin->update($id, [
            'uniqueidentifier' => $request->input('uniqueidentifier'),
            'name'             => $request->input('name'),
            'screenshoturl'    => $request->input('screenshoturl'),
            'downloadlink'     => $request->input('downloadlink'),
            'description'      => $request->input('description'),
            'previewlink'      => $request->input('previewlink'),
            // 'status'           => 'detected',
        ]);


        if ($result) {

            $status = $this->pluginMeta->save([
                'pluginid' => $id,
                'slug'     => $request->input('slug'),
                'status'   => 'active',
            ]);

            return json_encode($status);
        }

        return \Response::json([
            'error' => ['Could not save plugin. Already exist'],
        ], 422);
    }


    /**
     * @param $plugin
     *
     * @return $this
     */
    public function show($plugin)
    {

        $plugin = \App\Models\Plugin::find($plugin);


        $next = DB::table('plugins')
                  ->where('id', '>', $plugin->id)
                  ->take(1)->get();

        $next = isset($next['0']->id) ? $next['0']->id : '1';

        $previous = DB::table('plugins')
                      ->where('id', '<', $plugin->id)
                      ->orderBy('id', 'desc')
                      ->take(1)->get();
        //dd($plugin->id,$previous);

        $previous = isset($previous['0']->id) ? $previous['0']->id : '1';

        return view('admin/plugin')
            ->with('plugin', $plugin)
            ->with('next', $next)
            ->with('previous', $previous);

    }
}
