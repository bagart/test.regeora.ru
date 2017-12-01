<?php

namespace App\Modules\Sync\Transport\Raspvariant\Object;

use App\Models\Transport\Graph;
use App\Modules\Sync\Interfaces\ConvertObjectEloquentInterface;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Traits\ConverterObjectTrait;
use App\Modules\Sync\Traits\RulesTrait;

class GraphConvertObject implements ConvertRulesInterface, ConvertObjectEloquentInterface
{
    use ConverterObjectTrait;
    use RulesTrait;

    const CLASS_NAME = Graph::class;
    const EXT_PRIMARY = ['num'];


    const RULES = [
        'raspvariant_id',
        'num',
        'nullRun' => [
            'convert_method' => 'convertDistanceKmToM',
            'prop' => 'nullRun_meter',
        ],
        'lineRun' => [
            'convert_method' => 'convertDistanceKmToM',
            'prop' => 'lineRun_meter',
        ],
        'totalRun' => [
            'convert_method' => 'convertDistanceKmToM',
            'prop' => 'totalRun_meter',
        ],
        'nullTime',
        'lineTime',
        'otsTime',
        'totalTime',
        'garageOut' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'garageOut_minute',
        ],
        'garageIn' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'garageIn_minute',
        ],
        'lineBegin' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'lineBegin_minute',
        ],
        'lineEnd' => [
            'convert_method' => 'convertTimeToMinute',
            'prop' => 'lineEnd_minute',
        ],
    ];
}
