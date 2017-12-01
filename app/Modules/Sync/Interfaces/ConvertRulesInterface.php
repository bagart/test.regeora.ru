<?php

namespace App\Modules\Sync\Interfaces;

interface ConvertRulesInterface
{
    public function getRules() : array;

    public function getClassName() : string;

    public function getObject(array $prop);
}
