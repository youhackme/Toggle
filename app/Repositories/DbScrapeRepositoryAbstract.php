<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 22:21.
 */

namespace App\Repositories;

abstract class DbScrapeRepositoryAbstract
{
    /**
     * Eloquent model.
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Do you exists already in our database?
     *
     * @param $externalIdentifier
     *
     * @return bool
     */
    public function exist($externalIdentifier)
    {
        if ( ! $this->model->where('uniqueidentifier', '=', $externalIdentifier)->exists()) {
            echo '[' . getMemUsage() . "]$externalIdentifier is new.";
            echo br();

            return true;
        } else {
            echo '[' . getMemUsage() . "]$externalIdentifier has already been scrapped.";
            echo br();

            return false;
        }
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
        if ($this->exist(trim($data['uniqueidentifier']))) {
            return $this->model->create($data);
        } else {
            return false;
        }
    }

    /**
     * @param          $chunk
     * @param callable $callback
     *
     * @return mixed
     */
    public function chunk($chunk, callable $callback)
    {
        return $this->model->where('status', 'unprocessed')
                           ->where('previewlink', '!=', '')
                           ->chunk($chunk, $callback);
    }

    /**
     * Update status.
     *
     * @param $id     The primary key of the theme or plugin
     * @param $status The status to update
     *
     * @return mixed
     */
    public function update($id, $status)
    {
        return $this->model->where('id', $id)
                           ->update(['status' => $status]);
    }
}
