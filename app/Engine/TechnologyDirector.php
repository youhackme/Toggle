<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 11/12/2017
 * Time: 22:04
 */

namespace App\Engine;


class TechnologyDirector
{
    private $builder = null;

    public function __construct(TechnologyBuilderInterface $jsonResponseBuilder)
    {
        $this->builder = $jsonResponseBuilder;
    }

    public function build()
    {
        $this->builder->addUrl();
        $this->builder->addHost();
        $this->builder->addDebugMode(false);
        $this->builder->addApplication();
        $this->builder->addApplicationsByCategory();

        return $this->builder->formatJson();
    }

}