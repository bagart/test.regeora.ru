<?php

namespace App\Modules\Sync\Transport\Raspvariant\Object;

use App\Models\Sync\Raspvariant;
use App\Modules\Sync\Interfaces\ConvertObjectEloquentInterface;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Traits\ConverterObjectTrait;
use App\Modules\Sync\Traits\RulesTrait;

class RaspvariantConvertObject implements ConvertRulesInterface, ConvertObjectEloquentInterface
{
    use ConverterObjectTrait;
    use RulesTrait;

    const EXT_PRIMARY = ['ext_mr_id', 'ext_mr_num'];

    const CLASS_NAME = Raspvariant::class;

    const RULES = [
        'snapTime',
        'num',
        'start',
        'end' => [
            'filter' => true,
        ],
        'dow',
        'mr_id' => [
            'prop' => 'ext_mr_id',
        ],
        'mr_num' => [
            'prop' => 'ext_mr_num',
        ],
    ];
}
