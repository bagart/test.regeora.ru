<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    /**
     * @var integer
     */
    public $num;

    /**
     * @var integer
     */
    public $nullRun_meter;

    /**
     * @var integer
     */
    public $lineRun_meter;

    /**
     * @var integer
     */
    public $totalRun_meter;

    /**
     * @var integer
     */
    public $nullTime;


    /**
     * @var integer
     */
    public $lineTime;

    /**
     * @var integer
     */
    public $otsTime;

    /**
     * @var integer
     */
    public $totalTime;

    /**
     * @var integer
     */
    public $garageOut_minute;

    /**
     * @var integer
     */
    public $garageIn_minute;

    /**
     * @var integer|
     */
    public $lineBegin_minute;

    /**
     * @var integer
     */
    public $lineEnd_minute;

    /**
     * @var integer
     */
    public $raspvariant_id;

    protected $fillable = [
        'raspvariant_id',
        'num',
        'nullRun_meter',
        'lineRun_meter',
        'totalRun_meter',
        'nullTime',
        'lineTime',
        'otsTime',
        'totalTime',
        'garageOut_minute',
        'garageIn_minute',
        'lineBegin_minute',
        'lineEnd_minute',
    ];

    public function smeny()
    {
        return $this->hasMany(Smena::class)->orderBy('smena');
    }

    public function getIndustrialEventCount()
    {
        return $this
            ->smeny()
            ->select(\DB::raw('count(smeny.id) as count'))
            ->join('events', 'events.smena_id', 'smeny.id')
            ->where('events.is_industrial', 1)
            ->first()
            ->count;
    }

    public function getIndustrialStopsAt($from, $to)
    {
        $event_ids = $this
            ->smeny()
            ->select('events.id event_id')
            ->join('events', 'events.smena_id', 'smeny.id')
            ->where('events.is_industrial', 1)
            ->where('events.start_minute', 1)
            ->get();
        dd($event_ids);
    }
    public function getIndustrialTimeCount()
    {
        return $this
            ->smeny()
            ->select(\DB::raw('sum(events.end_minute - events.start_minute) as minute'))
            ->join('events', 'events.smena_id', 'smeny.id')
            ->where('events.is_industrial', 1)
            ->first()
            ->minute;
    }
}
