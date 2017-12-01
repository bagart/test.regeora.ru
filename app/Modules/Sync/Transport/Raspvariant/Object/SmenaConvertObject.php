<?php

namespace App\Modules\Sync\Transport\Raspvariant\Object;

use App\Models\Transport\Smena;
use App\Modules\Sync\Interfaces\ConvertObjectEloquentInterface;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Traits\ConverterObjectTrait;
use App\Modules\Sync\Traits\RulesTrait;

class SmenaConvertObject implements ConvertRulesInterface, ConvertObjectEloquentInterface
{
    use ConverterObjectTrait;
    use RulesTrait;

    const CLASS_NAME = Smena::class;
    const EXT_PRIMARY = ['graph_id', 'smena'];


    const RULES = [
        'smena',
        'graph_id',
    ];
}
