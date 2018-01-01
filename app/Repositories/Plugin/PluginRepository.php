<?php

namespace App\Repositories\Plugin;

use App\Models\Plugin as PluginModel;
use App\Repositories\DbScrapeRepositoryAbstract;
use App\Repositories\ScrapeRepositoryInterface;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43.
 */
class PluginRepository extends DbScrapeRepositoryAbstract implements ScrapeRepositoryInterface
{
    /**
     * Eloquent model.
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(PluginModel $model)
    {
        $this->model = $model;
    }
}
