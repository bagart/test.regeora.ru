<?php

namespace App\Modules\Sync\Transport\Raspvariant\Object;

use App\Models\Transport\Event;
use App\Modules\Sync\Interfaces\ConvertObjectEloquentInterface;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Traits\ConverterObjectTrait;
use App\Modules\Sync\Traits\RulesTrait;

class EventConvertObject implements ConvertRulesInterface, ConvertObjectEloquentInterface
{
    use ConverterObjectTrait;
    use RulesTrait;

    const CLASS_NAME = Event::class;
    const EXT_PRIMARY = ['smena_id', 'ext_id', 'start_minute'];


    const RULES = [
        'ev_id' => [
            'prop' => 'ext_id',
        ],
        'start' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'start_minute',
        ],
        'end' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'end_minute',
        ],
        'departureID' => [
            'prop' => 'ext_departure_id',
        ],
        'arrivalID' => [
            'prop' => 'ext_arrival_id',
        ],
        'distance' => [
            'convert_method' => 'convertDistanceKmToM',
            'prop' => 'distance_meter',
        ],
        'duration',
        'smena_id',
        [
            'replace' => [self::class, 'is_industrial'],
            'prop' => 'is_industrial'
        ],
    ];

    public static function is_industrial(array $prop)
    {
        return $prop['ext_id'] == 4;
    }
}
