<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 11/12/2017
 * Time: 22:03
 */

namespace App\Engine;

use Request;

class LiveTechnologyBuilder extends TechnologyBuilderAbstract implements TechnologyBuilderInterface
{
    /**
     *  Fetch result from a live search using the underlying headless browser
     */
    public function addApplication()
    {
        $this->applications = (new Application(Request::all()))->analyze();
    }

}