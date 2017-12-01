<?php

namespace App\Modules\Sync\Transport\Raspvariant\Object;

use App\Models\Transport\Stop;
use App\Modules\Sync\Interfaces\ConvertObjectEloquentInterface;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Traits\ConverterObjectTrait;
use App\Modules\Sync\Traits\RulesTrait;

class StopConvertObject implements ConvertRulesInterface, ConvertObjectEloquentInterface
{
    use ConverterObjectTrait;
    use RulesTrait;

    const EXT_PRIMARY = ['event_id', 'ext_id']; //note probably [ext_id]

    const CLASS_NAME = Stop::class;

    const RULES = [
        'kp',
        'distanceToNext' => [
            'convert_method' => 'convertDistanceKmToM',
            'prop' => 'distanceToNext_meter',
        ],
        'time' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'time_minute',
        ],
        'st_id' => [
            'prop' => 'ext_id',
        ],
        'event_id'
    ];
}
