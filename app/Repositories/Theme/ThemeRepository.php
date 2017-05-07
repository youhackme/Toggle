<?php

namespace App\Repositories\Theme;

use App\Models\Theme as ThemeModel;
use App\Repositories\ScrapeRepositoryInterface;
use App\Repositories\DbScrapeRepositoryAbstract;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43.
 */
class ThemeRepository extends DbScrapeRepositoryAbstract implements ScrapeRepositoryInterface
{
    /**
     * Eloquent model.
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(ThemeModel $model)
    {
        $this->model = $model;
    }
}
