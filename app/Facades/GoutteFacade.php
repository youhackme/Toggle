<?php

namespace App\Facades;

/*
 * Created by PhpStorm.
 * User: Hyder
 * Date: 04/04/2017
 * Time: 12:07
 */

use Illuminate\Support\Facades\Facade;

class GoutteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'goutte';
    }
}
