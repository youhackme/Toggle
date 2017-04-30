<?php

namespace App\Repositories\Theme;

use App\Models\ThemeMeta as ThemeMetaModel;


/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43.
 */
class ThemeMetaRepository
{
    /**
     * Eloquent model.
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(ThemeMetaModel $model)
    {
        $this->model = $model;
    }
}
