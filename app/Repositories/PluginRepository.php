<?php

namespace App\Repositories;

use App\Models\Plugin as PluginModel;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43
 */
class PluginRepository
{

    public function exist($externalPluginIdentifier)
    {
        if ( ! PluginModel::where('uniqueidentifier', '=', $externalPluginIdentifier)->exists()) {
            echo "[" . getMemUsage() . "]$externalPluginIdentifier is a new plugin.";
            echo br();

            return true;
        } else {
            echo "[" . getMemUsage() . "]$externalPluginIdentifier has already been scrapped.";
            echo br();

            return false;
        }

    }


}