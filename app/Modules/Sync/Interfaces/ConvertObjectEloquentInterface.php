<?php

namespace App\Modules\Sync\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ConvertObjectEloquentInterface
{
    //const DO_NOT_STRIP = true;

    public function getPreparedObject($prop) : Model;
}