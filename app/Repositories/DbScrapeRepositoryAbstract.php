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
     * @param $provider
     *
     * @return bool
     */
    public function exist($externalIdentifier, $provider)
    {
        if ( ! $this->model
            ->where('uniqueidentifier', '=', $externalIdentifier)
            ->where('provider', '=', $provider)
            ->exists()
        ) {

            return true;
        }

        return false;
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
        if ($this->exist(trim($data['uniqueidentifier']), $data['provider'])) {
            return $this->model->create($data);
        }

        return false;
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
     * @param       $id   The primary key of the theme or plugin
     * @param array $data Any data to update in key-value pair
     *
     * @return mixed
     */
    public function update($id, Array $data)
    {
        return $this->model->where('id', $id)
                           ->update($data);

    }
}
