<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 17/06/2017
 * Time: 15:47
 */

namespace App\Engine\Bot;

use App\Http\Requests\ScanTechnologiesRequest;

interface BotInterface
{
    public function request(ScanTechnologiesRequest $request);

    public function headers();

    public function cookies();

    public function status();

    public function url();

    public function host();

    public function html();
}