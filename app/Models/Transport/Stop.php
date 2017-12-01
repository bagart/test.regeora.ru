<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    /**
     * internal ID needed
     * @var string
     */
    public $ext_id;

    /**
     * @var integer
     */
    public $time_minute;

    /**
     * @var integer
     */
    public $distanceToNext_meter;

    /**
     * @var integer
     */
    public $event_id;
    /**
     * @var integer
     */
    public $kp;

    protected $fillable = [
        'kp',
        'distanceToNext_meter',
        'time_minute',
        'ext_id',
        'event_id',
    ];


    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public static function getIndustrialStopsBetween($start_minute, $from_minute)
    {
        return static::whereHas('events', function($query) {
            $query->where('is_industrial', 1);
        })
            ->where('time_minute', '<=', $from_minute)
            ->where('time_minute', '>=', $start_minute)
            ->get();
    }
}