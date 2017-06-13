<?php

namespace App\Repositories\Plugin;

use App\Models\PluginMeta as PluginMetaModel;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43.
 */
class PluginMetaRepository
{
    /**
     * Eloquent model.
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(PluginMetaModel $model)
    {
        $this->model = $model;
    }


    /**
     * Save data only if it is new.
     *
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data)
    {
        if ($this->exist(trim($data['pluginid']), $data['slug'])) {
            return $this->model->create($data);
        } else {
            return false;
        }
    }

    /**
     * @param $pluginid
     * @param $slug
     *
     * @return bool
     */
    public function exist($pluginid, $slug)
    {
        if ( ! $this->model
            ->where('pluginid', '=', $pluginid)
            ->where('slug', '=', $slug)
            ->exists()
        ) {

            return true;
        } else {

            return false;
        }
    }
}
