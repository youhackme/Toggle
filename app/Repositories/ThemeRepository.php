<?php

namespace App\Repositories;
use App\Models\Theme as ThemeModel;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43
 */
class ThemeRepository
{

    public function exist($externalThemeIdentifier)
    {


        if ( ! ThemeModel::where('uniqueidentifier', '=', $externalThemeIdentifier)->exists()) {
            echo "[" . getMemUsage() . "]$externalThemeIdentifier is a new Theme.";
            echo br();

            return true;
        } else {
            echo "[" . getMemUsage() . "]$externalThemeIdentifier has already been scrapped.";
            echo br();

            return false;
        }

    }

}