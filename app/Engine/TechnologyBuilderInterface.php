<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 11/12/2017
 * Time: 21:39
 */

namespace App\Engine;

interface TechnologyBuilderInterface
{
    public function addUrl();

    public function addHost();

    public function addDebugMode();

    public function addApplication();

    public function addApplicationsByCategory();

    public function formatJson();

}