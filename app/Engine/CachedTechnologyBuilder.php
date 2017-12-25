<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 11/12/2017
 * Time: 22:03
 */

namespace App\Engine;

use App\Engine\Elastic\Technologies;
use Request;

class CachedTechnologyBuilder extends TechnologyBuilderAbstract implements TechnologyBuilderInterface
{
    /**
     *  Query ElasticSearch here and get result
     */
    public function addApplication()
    {
        $technologies       = new Technologies(
            $this->request
        );
        $applications       = $technologies->result();
        $this->applications = $applications['applications'];
    }
}