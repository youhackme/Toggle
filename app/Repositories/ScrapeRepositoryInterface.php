<?php

namespace App\Repositories;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 14/04/2017
 * Time: 20:43.
 */
interface ScrapeRepositoryInterface
{
    /**
     * Have we already saved this theme/plugin before? Based on its external unique identifier.
     * Based on the provider as well
     *
     * @param $externalIdentifier
     * @param provider
     */
    public function exist($externalIdentifier, $provider);
}
